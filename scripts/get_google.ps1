$client = New-Object System.Net.WebClient
$client.Headers.Add("User-Agent", "Mozilla/5.0")
$client.DownloadFile("https://lh3.googleusercontent.com/p/AF1QipM4W2JqMkWi5aCRVjWaJ0hC-LrMqsxbK3IgVj70=w1600-h1066-k-no", "public\images\hotel\google-1.jpg")
$client.DownloadFile("https://lh3.googleusercontent.com/p/AF1QipOEMvQHeqcFKyvrykPUqdYNMoAOehbhwGATXhwU=w1600-h1066-k-no", "public\images\hotel\google-2.jpg")
$client.DownloadFile("https://lh3.googleusercontent.com/p/AF1QipMnOiSO8SmEiX9NB_kvvS6b-peAai3_7KgU03UX=w1600-h1066-k-no", "public\images\hotel\google-3.jpg")
