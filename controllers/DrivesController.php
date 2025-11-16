<?php

class DrivesController {

    // -----------------------------------------
    // LISTAR UNIDADES (usa Get-Volume -> JSON)
    // -----------------------------------------
    public function listDrives() {
        $cmd = 'powershell -Command "Get-Volume | Select-Object DriveLetter, FileSystemLabel, DriveType | ConvertTo-Json"';
        $output = shell_exec($cmd);

        $data = json_decode($output, true);
        if (!$data) return [];

        // Si solo hay un objeto, json_decode devuelve un associative array, no array de arrays
        if (isset($data['DriveLetter'])) {
            $data = [$data];
        }

        $drives = [];
        foreach ($data as $vol) {
            $drives[] = [
                "Letter" => $vol["DriveLetter"] ?? "",
                "Volume" => $vol["FileSystemLabel"] ?? "(Sin nombre)",
                "Type"   => $vol["DriveType"] ?? "Unknown",
            ];
        }

        return $drives;
    }


    // -----------------------------------------
    // OBTENER UNIDADES OCULTAS (Registro - NoViewOnDrive / NoDrives)
    // -----------------------------------------
    public function getHiddenDrivesReg() {
        // Revisamos primero NoViewOnDrive (más común en HKCU), si no existe, intentamos NoDrives en HKLM
        $pathHKCU = 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer';
        $pathHKLM = 'HKLM:\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer';

        // Intentar leer NoViewOnDrive en HKCU
        $cmd1 = "powershell -Command \"try { if (Test-Path '$pathHKCU') { (Get-ItemProperty -Path '$pathHKCU' -Name NoViewOnDrive -ErrorAction Stop).NoViewOnDrive } else { 0 } } catch { 0 }\"";
        $out1 = trim(shell_exec($cmd1));

        if ($out1 !== "" && is_numeric($out1) && (int)$out1 > 0) {
            $mask = (int)$out1;
        } else {
            // Intentar NoDrives en HKLM (valor usado por otras guías)
            $cmd2 = "powershell -Command \"try { if (Test-Path '$pathHKLM') { (Get-ItemProperty -Path '$pathHKLM' -Name NoDrives -ErrorAction Stop).NoDrives } else { 0 } } catch { 0 }\"";
            $out2 = trim(shell_exec($cmd2));
            $mask = (is_numeric($out2) ? (int)$out2 : 0);
        }

        if ($mask === 0) return [];

        $letters = [];
        $alphabet = range('A', 'Z');
        for ($i = 0; $i < 26; $i++) {
            if ($mask & (1 << $i)) {
                $letters[] = $alphabet[$i];
            }
        }

        return $letters;
    }


    // -----------------------------------------
    // OCULTAR UNA UNIDAD (establece la máscara en HKCU\...\Explorer -> NoViewOnDrive)
    // -----------------------------------------
    public function hideDriveReg($letter) {
        $letter = strtoupper(substr($letter, 0, 1));
        if ($letter < 'A' || $letter > 'Z') return;

        $index = ord($letter) - 65;
        $value = (1 << $index);

        $path = 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer';
        // Establece el valor directamente (sobrescribe)
        $cmd = "powershell -Command \"if (!(Test-Path '$path')) { New-Item -Path '$path' -Force | Out-Null }; Set-ItemProperty -Path '$path' -Name NoViewOnDrive -Value $value -Force\"";
        shell_exec($cmd);
    }


    // -----------------------------------------
    // MOSTRAR (elimina el valor que oculta unidades)
    // -----------------------------------------
    public function showAllDrivesReg() {
        $path = 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer';
        $cmd = "powershell -Command \"if (Test-Path '$path') { Remove-ItemProperty -Path '$path' -Name NoViewOnDrive -ErrorAction SilentlyContinue }\"";
        shell_exec($cmd);
    }


    // -----------------------------------------
    // QUITAR LETRA (Remove-PartitionAccessPath para la letra específica)
    // -----------------------------------------
    public function removeLetter($letter) {
        $letter = strtoupper(substr($letter, 0, 1));
        if ($letter < 'A' || $letter > 'Z') return;

        // Intentar con Get-Partition (recomendado en Win10+)
        $cmd = "powershell -Command \"try { Get-Partition -DriveLetter '$letter' -ErrorAction Stop | ForEach-Object { \$p=\$_; Remove-PartitionAccessPath -InputObject \$p -AccessPath '$letter:' -ErrorAction SilentlyContinue } } catch { }\"";
        shell_exec($cmd);
    }


    // -----------------------------------------
    // ASIGNAR LETRA: asigna la letra proporcionada a la primera partición sin letra
    // -----------------------------------------
    public function assignLetter($letter) {
        $letter = strtoupper(substr($letter, 0, 1));
        if ($letter < 'A' || $letter > 'Z') return;

        // Buscamos la primera partición sin letra y le asignamos la letra indicada
        $cmd = "powershell -Command \"try { \$p = Get-Partition | Where-Object { -not \$_.DriveLetter } | Select-Object -First 1; if (\$p) { Add-PartitionAccessPath -InputObject \$p -AccessPath '$letter:' -ErrorAction SilentlyContinue } } catch { }\"";
        shell_exec($cmd);
    }

}
