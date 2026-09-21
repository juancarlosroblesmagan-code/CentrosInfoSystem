import subprocess
import asyncio
import json
import base64
import websockets
import urllib.request
import time

async def preview():
    chrome_path = r'C:\Program Files\Google\Chrome\Application\chrome.exe'
    port = 9222
    t = int(time.time())
    
    proc = subprocess.Popen([
        chrome_path,
        '--headless=new',
        f'--remote-debugging-port={port}',
        '--window-size=1500,950',
        '--disable-gpu',
        f'https://centrosinfosystem.com/?nocache={t}'
    ])
    
    await asyncio.sleep(4)
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
            await asyncio.sleep(1)
            
            # Hide cookies banner
            await send('Runtime.evaluate', {
                'expression': 'document.querySelectorAll(".tc-modal, .thimcookie-banner, #cookie-banner").forEach(el => el.style.display = "none");'
            })
            
            # Apply Concept 1: Circular Luxury FAB with Badge
            js_circular = """
            var old = document.getElementById("infosystem-preview-style");
            if (old) old.remove();
            
            var s = document.createElement("style");
            s.id = "infosystem-preview-style";
            s.innerHTML = `
                .infosystem-wa-launcher {
                    position: relative !important;
                    width: 62px !important;
                    height: 62px !important;
                    border-radius: 50% !important;
                    padding: 0 !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    background: linear-gradient(145deg, #25D366 0%, #128C7E 100%) !important;
                    box-shadow: 0 8px 24px -2px rgba(18, 140, 126, 0.5), 0 3px 10px rgba(0, 0, 0, 0.12) !important;
                    border: 2px solid rgba(255, 255, 255, 0.4) !important;
                    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                }
                .infosystem-wa-launcher:hover {
                    transform: translateY(-4px) scale(1.06) !important;
                    box-shadow: 0 14px 30px -2px rgba(18, 140, 126, 0.6), 0 6px 14px rgba(0, 0, 0, 0.15) !important;
                }
                .infosystem-wa-launcher .infosystem-wa-icon {
                    width: 32px !important;
                    height: 32px !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15)) !important;
                }
                .infosystem-wa-launcher .infosystem-wa-icon svg {
                    width: 32px !important;
                    height: 32px !important;
                }
                .infosystem-wa-badge-text {
                    position: absolute !important;
                    top: -6px !important;
                    right: -6px !important;
                    background: #1e293b !important;
                    color: #fbbf24 !important;
                    border: 1.5px solid #d97706 !important;
                    font-size: 10px !important;
                    font-weight: 800 !important;
                    padding: 2px 7px !important;
                    border-radius: 999px !important;
                    box-shadow: 0 3px 8px rgba(0,0,0,0.25) !important;
                    letter-spacing: 0.3px !important;
                    display: flex !important;
                    align-items: center !important;
                    gap: 3px !important;
                }
                .infosystem-wa-status-badge {
                    display: none !important;
                }
            `;
            document.head.appendChild(s);
            
            var bText = document.querySelector(".infosystem-wa-badge-text");
            if (bText) bText.innerHTML = "🌙 IA 24h";
            """
            
            await send('Runtime.evaluate', {'expression': js_circular})
            await asyncio.sleep(1)
            
            res_ss1 = await send('Page.captureScreenshot', {'format': 'png'})
            with open('preview_circular_fab.png', 'wb') as f:
                f.write(base64.b64decode(res_ss1['data']))
            print("Saved preview_circular_fab.png")
            
            # Apply Concept 2: Elegant Executive Pill / Capsule with subtext
            js_capsule = """
            var s = document.getElementById("infosystem-preview-style");
            s.innerHTML = `
                .infosystem-wa-launcher {
                    display: flex !important;
                    align-items: center !important;
                    gap: 12px !important;
                    height: 52px !important;
                    padding: 6px 18px 6px 8px !important;
                    border-radius: 999px !important;
                    background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #10b981 100%) !important;
                    border: 1px solid rgba(255, 255, 255, 0.35) !important;
                    box-shadow: 0 8px 24px -2px rgba(15, 118, 110, 0.4), 0 3px 10px rgba(0, 0, 0, 0.1) !important;
                    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                }
                .infosystem-wa-launcher:hover {
                    transform: translateY(-3px) scale(1.02) !important;
                    box-shadow: 0 12px 28px -2px rgba(15, 118, 110, 0.5), 0 5px 12px rgba(0, 0, 0, 0.12) !important;
                }
                .infosystem-wa-launcher .infosystem-wa-icon {
                    width: 38px !important;
                    height: 38px !important;
                    background: #ffffff !important;
                    border-radius: 50% !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
                }
                .infosystem-wa-launcher .infosystem-wa-icon svg {
                    width: 22px !important;
                    height: 22px !important;
                    fill: #0f766e !important;
                }
                .infosystem-wa-badge-text {
                    display: flex !important;
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    gap: 0 !important;
                    font-size: 13.5px !important;
                    font-weight: 700 !important;
                    color: #ffffff !important;
                    line-height: 1.2 !important;
                }
                .infosystem-wa-badge-text::after {
                    content: "🌙 Asistente IA 24h" !important;
                    font-size: 11px !important;
                    font-weight: 500 !important;
                    color: #fef08a !important;
                    letter-spacing: 0.2px !important;
                }
                .infosystem-wa-status-badge {
                    display: none !important;
                }
            `;
            var bText = document.querySelector(".infosystem-wa-badge-text");
            if (bText) bText.innerHTML = "WhatsApp";
            """
            
            await send('Runtime.evaluate', {'expression': js_capsule})
            await asyncio.sleep(1)
            
            res_ss2 = await send('Page.captureScreenshot', {'format': 'png'})
            with open('preview_capsule_luxury.png', 'wb') as f:
                f.write(base64.b64decode(res_ss2['data']))
            print("Saved preview_capsule_luxury.png")
            
    finally:
        proc.terminate()
        try: proc.wait(timeout=2)
        except: proc.kill()

if __name__ == '__main__':
    asyncio.run(preview())
