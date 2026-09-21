import requests
import json
import subprocess
import asyncio
import base64
import websockets
import urllib.request
import time

def test_endpoints():
    print("Testing REST API endpoints on live site...")
    
    # 1. Test Bot Chat
    url_chat = "https://centrosinfosystem.com/wp-json/infosystem/v1/bot-chat"
    resp_chat = requests.post(url_chat, json={"message": "¿Qué cursos tenéis de informática y cuánto cuestan?"}, timeout=15)
    print(f"Chat endpoint status: {resp_chat.status_code}")
    print("Chat reply:", resp_chat.json().get("reply")[:150])
    
    # 2. Test Bot Schedule (validation)
    url_sched = "https://centrosinfosystem.com/wp-json/infosystem/v1/bot-schedule"
    resp_sched = requests.post(url_sched, json={
        "nombre": "Prueba Verificacion",
        "telefono": "619061933",
        "horario": "Mañana",
        "curso": "Test Automatizado"
    }, timeout=15)
    print(f"Schedule endpoint status: {resp_sched.status_code}")
    print("Schedule reply:", resp_sched.json())

async def capture_widget_views():
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
            
            # Check 1: Widget Launcher visible
            res_launcher = await send('Runtime.evaluate', {
                'expression': '!!document.getElementById("infosystem-wa-widget")',
                'returnByValue': True
            })
            print("Widget element found in DOM:", res_launcher.get('result', {}).get('value'))
            
            # Open widget in Night Mode (current time 22h is out of hours)
            await send('Runtime.evaluate', {
                'expression': '''
                document.getElementById("infosystem-wa-launcher").click();
                '''
            })
            await asyncio.sleep(1)
            
            res_ss_night = await send('Page.captureScreenshot', {'format': 'png'})
            with open('live_whatsapp_night_bot.png', 'wb') as f:
                f.write(base64.b64decode(res_ss_night['data']))
            print("Saved live_whatsapp_night_bot.png")
            
            # Now simulate Day Mode (08:00 to 20:00) to verify active WhatsApp screen
            await send('Runtime.evaluate', {
                'expression': '''
                var widget = document.getElementById("infosystem-wa-widget");
                widget.setAttribute("data-active", "1");
                var badge = document.querySelector(".infosystem-wa-status-badge");
                var badgeText = document.querySelector(".infosystem-wa-badge-text");
                var statusDot = document.querySelector(".infosystem-wa-avatar-status");
                var statusLabel = document.querySelector(".infosystem-wa-status-label");
                var modeActive = document.getElementById("infosystem-mode-active");
                var modeNight = document.getElementById("infosystem-mode-night");
                
                badge.className = "infosystem-wa-status-badge active-hours";
                badgeText.textContent = "WhatsApp";
                statusDot.className = "infosystem-wa-avatar-status status-online";
                statusLabel.innerHTML = "<span class=\\"dot-green\\">●</span> En directo · Asesoría de 8:00h a 20:00h";
                modeActive.classList.add("is-visible");
                modeActive.classList.remove("is-hidden");
                modeNight.classList.remove("is-visible");
                modeNight.classList.add("is-hidden");
                '''
            })
            await asyncio.sleep(1)
            
            res_ss_day = await send('Page.captureScreenshot', {'format': 'png'})
            with open('live_whatsapp_day_active.png', 'wb') as f:
                f.write(base64.b64decode(res_ss_day['data']))
            print("Saved live_whatsapp_day_active.png")
            
    finally:
        proc.terminate()
        try: proc.wait(timeout=2)
        except: proc.kill()

if __name__ == '__main__':
    test_endpoints()
    asyncio.run(capture_widget_views())
