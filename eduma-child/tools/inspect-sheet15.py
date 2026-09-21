import subprocess
import asyncio
import json
import websockets
import urllib.request
import time

async def inspect_sheet_15():
    chrome_path = r'C:\Program Files\Google\Chrome\Application\chrome.exe'
    port = 9445
    t = int(time.time())
    
    proc = subprocess.Popen([
        chrome_path,
        '--headless=new',
        f'--remote-debugging-port={port}',
        '--window-size=1440,900',
        '--disable-gpu',
        f'https://centrosinfosystem.com/contacto/?nocache={t}'
    ])
    
    await asyncio.sleep(5)
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
            
            res = await send('Runtime.evaluate', {
                'expression': '''
                (function() {
                    var s = document.styleSheets[15];
                    var node = s.ownerNode;
                    return {
                        id: node ? node.id : "",
                        tagName: node ? node.tagName : "",
                        className: node ? node.className : "",
                        rulesCount: s.cssRules ? s.cssRules.length : 0,
                        sampleRule: s.cssRules && s.cssRules[0] ? s.cssRules[0].cssText : ""
                    };
                })()
                ''',
                'returnByValue': True
            })
            print("SHEET 15 INFO:", json.dumps(res.get('result', {}).get('value'), indent=2))
            
            # Also find which stylesheet has "infosystem-dynamic-css"
            dyn_res = await send('Runtime.evaluate', {
                'expression': '''
                (function() {
                    var el = document.getElementById("infosystem-dynamic-css");
                    if (!el) return "NOT FOUND";
                    return {
                        id: el.id,
                        innerHTML_sample: el.innerHTML.slice(el.innerHTML.indexOf("PÁGINA DE CONTACTO") - 50, el.innerHTML.indexOf("PÁGINA DE CONTACTO") + 300)
                    };
                })()
                ''',
                'returnByValue': True
            })
            print("DYNAMIC CSS ELEMENT:", json.dumps(dyn_res.get('result', {}).get('value'), indent=2))
    finally:
        proc.terminate()

if __name__ == '__main__':
    asyncio.run(inspect_sheet_15())
