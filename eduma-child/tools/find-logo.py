import requests
import re

r = requests.get('https://centrosinfosystem.com/', headers={'User-Agent': 'Mozilla/5.0'})
matches = re.findall(r'https://centrosinfosystem\.com/wp-content/uploads/[^\s"\'<>]+\.(?:png|jpg|jpeg|webp|svg)', r.text, re.IGNORECASE)
unique = list(dict.fromkeys(matches))
print(f"Total image URLs found: {len(unique)}")
for u in unique:
    if any(k in u.lower() for k in ['logo', 'cropped', 'icon', 'favicon', 'info']):
        print("MATCH:", u)
