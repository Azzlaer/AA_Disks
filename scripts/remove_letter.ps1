param([string]$drive)

$vol = Get-Volume -DriveLetter $drive
if ($vol) {
    Remove-PartitionAccessPath -DiskNumber $vol.DriveLetter -AccessPath "$drive`:\" -ErrorAction SilentlyContinue
}
