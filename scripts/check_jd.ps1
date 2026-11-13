$client = New-Object System.Net.WebClient
$client.Headers.Add("User-Agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36")
try {
    $html = $client.DownloadString("https://www.justdial.com/Surat/Hotel-Rose-Palace-Behind-Marvella-Corridor-Near-Shyam-Mandir-Near-Croma-Vesu/0261PX261-X261-240108151241-K8S1_BZDET")
    Write-Output "Justdial length: $($html.Length)"
    $matches = [regex]::Matches($html, 'https://content\.jdmagicbox\.com/[^"''\\s\)]+')
    Write-Output "Found $($matches.Count) JD image matches:"
    $unique = $matches | ForEach-Object { $_.Value } | Select-Object -Unique
    foreach ($u in $unique | Select-Object -First 25) {
        Write-Output $u
    }
} catch {
    Write-Output "JD error: $($_.Exception.Message)"
}
