import requests
import re
import os

def deploy():
    session = requests.Session()
    session.headers.update({
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    })
    
    login_url = 'https://centrosinfosystem.com/wp-login.php'
    resp = session.get(login_url, timeout=25)
    
    # Try login as InfoSystem
    login_data = {
        'log': 'InfoSystem',
        'pwd': 't@C8im%@a87FSBADu$!Lj#s@',
        'wp-submit': 'Acceder',
        'redirect_to': 'https://centrosinfosystem.com/wp-admin/',
        'testcookie': '1'
    }
    
    login_resp = session.post(login_url, data=login_data, timeout=30)
    if 'wp-admin' not in login_resp.url and 'wordpress_logged_in' not in str(session.cookies):
        print("First login failed, trying CursosPremium...")
        login_data['log'] = 'CursosPremium'
        login_data['pwd'] = 'By7B1KSX@mPHg65#312xvt*4'
        login_resp = session.post(login_url, data=login_data, timeout=30)
    
    print("Login URL after submit:", login_resp.url)
    
    editor_url = "https://centrosinfosystem.com/wp-admin/theme-editor.php?file=functions.php&theme=infosystem-child-theme"
    editor_page = session.get(editor_url, timeout=25)
    
    m_nonce = re.search(r'name=["\']nonce["\']\s+value=["\']([^"\']+)["\']', editor_page.text)
    if not m_nonce:
        m_nonce = re.search(r'value=["\']([^"\']+)["\']\s+name=["\']nonce["\']', editor_page.text)
    
    if not m_nonce:
        print("Failed to get nonce from theme editor page!")
        print("Status code:", editor_page.status_code)
        return False
    
    nonce = m_nonce.group(1)
    print(f"Obtained Theme Editor Nonce: {nonce}")
    
    with open('eduma-child/functions.php', 'r', encoding='utf-8') as f:
        new_content = f.read()
    
    post_data = {
        'nonce': nonce,
        '_wp_http_referer': '/wp-admin/theme-editor.php?file=functions.php&theme=infosystem-child-theme',
        'newcontent': new_content,
        'action': 'update',
        'file': 'functions.php',
        'theme': 'infosystem-child-theme',
        'submit': 'Actualizar archivo'
    }
    
    post_resp = session.post('https://centrosinfosystem.com/wp-admin/theme-editor.php', data=post_data, timeout=40)
    print(f"Update response status: {post_resp.status_code}")
    
    if 'File edited successfully' in post_resp.text or 'El archivo se ha editado correctamente' in post_resp.text or 'Archivo editado correctamente' in post_resp.text:
        print("SUCCESS: Live functions.php updated cleanly!")
    else:
        print("Warning: Success message not explicitly matched. Checking notices:")
        notices = re.findall(r'<div[^>]*class=["\'][^"\']*notice[^"\']*["\'][^>]*>([\s\S]*?)</div>', post_resp.text)
        for n in notices:
            print("Notice:", re.sub(r'<[^>]+>', ' ', n).strip())
            
    # Purge WP Rocket Cache
    print("Purging WP Rocket Cache...")
    rocket_url = "https://centrosinfosystem.com/wp-admin/options-general.php?page=wprocket"
    r_page = session.get(rocket_url, timeout=25)
    m_purge = re.search(r'href=["\']([^"\']*action=purge_cache[^"\']*)["\']', r_page.text)
    if m_purge:
        purge_link = m_purge.group(1).replace('&amp;', '&')
        p_resp = session.get(purge_link, timeout=25)
        print(f"WP Rocket Purge Status: {p_resp.status_code}")
    else:
        print("Purge link not found on WP Rocket page, trying admin-bar purge...")
        m_dash_purge = re.search(r'href=["\']([^"\']*action=purge_cache[^"\']*)["\']', editor_page.text)
        if m_dash_purge:
            session.get(m_dash_purge.group(1).replace('&amp;', '&'), timeout=25)
            print("Admin-bar purge triggered!")

    return True

if __name__ == '__main__':
    deploy()
