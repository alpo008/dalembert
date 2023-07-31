export JAVA_HOME=/usr/lib/jvm/java-1.11.0-openjdk-amd64
cp ../public/css/app.css www/css/index.css
cp ../public/js/app.js www/js/index.js
cordova build android
