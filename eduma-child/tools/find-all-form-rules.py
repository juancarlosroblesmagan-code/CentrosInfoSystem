import subprocess
import asyncio
import json
import websockets
import urllib.request
import time

async def inspect_rule_source():
    chrome_path = r'C:\Program Files\Google\Chrome\Application\chrome.exe'
    port = 9435
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
            
            # Find all matching rules for form in CSS OM
            res = await send('Runtime.evaluate', {
                'expression': '''
                (function() {
                    var f = document.querySelector(".infosystem-contact-panel--form form.wpcf7-form");
                    var matched = [];
                    for (var i = 0; i < document.styleSheets.length; i++) {
                        var sheet = document.styleSheets[i];
                        try {
                            var rules = sheet.cssRules || sheet.rules;
                            for (var j = 0; j < rules.length; j++) {
                                var rule = rules[j];
                                if (rule.style) {
                                    if (f.matches(rule.selectorText)) {
                                        matched.push({
                                            sheetIndex: i,
                                            href: sheet.href ? sheet.href.split('/').pop() : "inline",
                                            selector: rule.selectorText,
                                            maxHeight: rule.style.maxHeight,
                                            overflowY: rule.style.overflowY,
                                            priority: rule.style.getPropertyPriority('max-height')
                                        });
                                    }
                                }
                            }
                        } catch(e) {}
                    }
                    return matched;
                })()
                ''',
                'returnByValue': True
            })
            print("ALL MATCHED RULES:", json.dumps(res.get('result', {}).get('value'), indent=2))
    finally:
        proc.terminate()

if __name__ == '__main__':
    asyncio.run(inspect_rule_source())
