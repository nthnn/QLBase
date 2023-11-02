echo [+] Building backend apps...
cd backend/auth && ./build.sh && cd ../..
cd backend/sms && ./build.sh && cd ../..
echo [+] Zipping deployment entity...
cd documentations && npm run build-only && cd ..
zip -r qlbase.zip api assets bin components controller docs scripts side styles views favicon.ico index.php sandbox.html
rm -rf docs/
echo [+] Deployment-ready successfully generated!