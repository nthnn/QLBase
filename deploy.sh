echo "\033[92m[+]\033[0m Building backend apps..."
cd backend/auth && ./build.sh && cd ../..
cd backend/data_analytics && ./build.sh && cd ../..
cd backend/database && ./build.sh && cd ../..
cd backend/forgetpass && ./build.sh && cd ../..
cd backend/sms && ./build.sh && cd ../..
cd backend/traffic && ./build.sh && cd ../..
echo "\033[92m[+]\033[0m Zipping deployment entity..."
cd documentations && npm install && npm run build-only && cd ..
zip -r qlbase.zip api assets bin components controller docs scripts side styles views favicon.ico index.php sandbox.html
rm -rf docs/
echo "\033[92m[+]\033[0m Deployment-ready successfully generated!"