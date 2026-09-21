import requests
import re

r = requests.get('https://centrosinfosystem.com/contacto/', headers={'User-Agent': 'Mozilla/5.0'})
text = r.text

idx = text.find('Escríbenos')
if idx == -1:
    idx = text.find('Escr&#237;benos')
if idx == -1:
    idx = text.find('Escr')

print("Found 'Escr' at index:", idx)
if idx != -1:
    snippet = text[max(0, idx - 1500): min(len(text), idx + 3500)]
    with open('C:/Users/JuanCarlosMagan/.gemini/antigravity-ide/brain/c0b69da5-6f29-4b60-97b8-33f1a7b8190e/contacto_snippet.html', 'w', encoding='utf-8') as f:
        f.write(snippet)
    print("Saved contacto_snippet.html!")

# Also check for form action or wpcf7 in full text
for m in re.finditer(r'<form[^>]*>[\s\S]*?</form>', text):
    print("Found form tag! Attributes:", m.group(0)[:200])
