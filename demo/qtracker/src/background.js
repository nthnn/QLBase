/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

// These are the localized version of the app
// key and ID on the development environment.
const Env = {
    key: "qba_a8c0ebe1e7_bfa0bae5",
    id: "7d08-c70a-7b0c-28bc"
};

const getDomain = (url)=> {
    try {
        return new URL(url).hostname;
    }
    catch {
        return null;
    }
}, generateRandomString = ()=> {
    const characters = "abcdefghijklmnopqrstuvwxyz";
    let result = "";

    for(let i = 0; i < 8; i++)
        result += characters[
            Math.floor(Math.random() * characters.length)
        ];
    return result;
}

const userUuid = generateRandomString(),
    anonUuid = generateRandomString();
chrome.tabs.onUpdated.addListener((tabId, changeInfo, tab) => {
    if(changeInfo.url) {
        const currentDomain = getDomain(changeInfo.url);

        fetch("http://localhost/qlbase/api/index.php?action=track_create_live_timestamp", {
            method: "POST",
            body: JSON.stringify({
                "tracker": generateRandomString(),
                "user_id": userUuid,
                "anon_id": anonUuid,
                "event": "visitevt",
                "payload": btoa(JSON.stringify({
                    "url": changeInfo.url,
                    "tab": tab,
                    "tab_id": tabId
                }))
            }),
            headers: {
                "QLBase-API-Key": Env.key,
                "QLBase-App-ID": Env.id,
                'Content-type': "application/json; charset=UTF-8"
            }
        })
        .then(response => {
            if(!response.ok)
                throw new Error(`Status Error: ${response.status}`);

            return response.json();
        });
    }
});
