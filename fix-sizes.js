const fs = require('fs');
const path = require('path');

function walkDir(dir, callback) {
  fs.readdirSync(dir).forEach(f => {
    let dirPath = path.join(dir, f);
    let isDirectory = fs.statSync(dirPath).isDirectory();
    isDirectory ? walkDir(dirPath, callback) : callback(path.join(dir, f));
  });
}

walkDir('app', function(filePath) {
  if (filePath.endsWith('.tsx')) {
    let content = fs.readFileSync(filePath, 'utf8');
    if (content.includes('<Image') && content.includes('fill')) {
        // Find <Image ... fill ... > and replace fill with fill sizes="100vw"
        // Also handle if sizes is already there
        if (!content.includes('sizes="100vw"')) {
            let newContent = content.replace(/(<Image[^>]*?)\bfill\b([^>]*?>)/g, '$1fill sizes="100vw"$2');
            if (newContent !== content) {
                fs.writeFileSync(filePath, newContent);
                console.log('Updated ' + filePath);
            }
        }
    }
  }
});
