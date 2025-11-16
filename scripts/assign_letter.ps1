param([string]$drive)

$vol = Get-Volume | Where-Object { $_.DriveLetter -eq $drive.ToUpper() -or !$_.DriveLetter }
if ($vol) {
    Add-PartitionAccessPath -DiskNumber $vol.DiskNumber -PartitionNumber $vol.PartitionNumber -AccessPath "$drive`:\" -ErrorAction SilentlyContinue
}
