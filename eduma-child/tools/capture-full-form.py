import subprocess
import asyncio
import json
import base64
import websockets
import urllib.request
import time

async def capture_full_form():
    chrome_path = r'C:\Program Files\Google\Chrome\Application\chrome.exe'
    port = 9475
    
    proc = subprocess.Popen([
        chrome_path,
        '--headless=new',
        f'--remote-debugging-port={port}',
        '--window-size=1440,1100',
        '--disable-gpu',
        'about:blank'
    ])
    
    await asyncio.sleep(3)
    try:
        with urllib.request.urlopen(f'http://127.0.0.1:{port}/json') as resp:
            pages = json.loads(resp.read().decode())
            target = next(p for p in pages if p.get('type') == 'page')
            ws_url = target['webSocketDebuggerUrl']
            
        async with websockets.connect(ws_url, max_size=20*1024*1024) as ws:
            msg_id = 1
            async def send(m, p=None):
                nonlocal msg_id
                cmd = {'id': msg_id, 'method': m}
                if p: cmd['params'] = p
                msg_id += 1
                await ws.send(json.dumps(cmd))
                while True:
                    r = json.loads(await ws.recv())
                    if r.get('id') == cmd['id']: return r.get('result', {})
            
            await send('Page.enable')
            await send('Page.navigate', {'url': 'https://centrosinfosystem.com/contacto/'})
            await asyncio.sleep(5)
            
            # Hide cookie banners
            await send('Runtime.evaluate', {
                'expression': 'document.querySelectorAll(".tc-modal, .thimcookie-banner, #cookie-banner").forEach(el => el.style.display = "none");'
            })
            
            # Capture the entire contact panels block perfectly
            box_res = await send('Runtime.evaluate', {
                'expression': '''
                (function() {
                    var el = document.querySelector(".infosystem-contact-layout");
                    if (!el) return null;
                    var r = el.getBoundingClientRect();
                    return { x: r.left, y: r.top + window.scrollY, width: r.width, height: r.height };
                })()
                ''',
                'returnByValue': True
            })
            box = box_res.get('result', {}).get('value')
            print("Layout Box:", box)
            
            if box:
                # Scroll to see the whole 3 panels and submit button
                await send('Runtime.evaluate', {
                    'expression': f'window.scrollTo(0, {box["y"] - 20});'
                })
                await asyncio.sleep(1)
                
                # Clip the layout directly
                clip_res = await send('Page.captureScreenshot', {
                    'format': 'png',
                    'clip': {
                        'x': max(0, box['x'] - 10),
                        'y': max(0, box['y'] - 10),
                        'width': box['width'] + 20,
                        'height': box['height'] + 20,
                        'scale': 1
                    },
                    'captureBeyondViewport': True
                })
                with open(r'C:\Users\JuanCarlosMagan\.gemini\antigravity-ide\brain\c0b69da5-6f29-4b60-97b8-33f1a7b8190e\live_contacto_full_layout.png', 'wb') as f:
                    f.write(base64.b64decode(clip_res['data']))
                print("Saved live_contacto_full_layout.png successfully!")
    finally:
        proc.terminate()

if __name__ == '__main__':
    asyncio.run(capture_full_form())
