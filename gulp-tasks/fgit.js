var ggs = require('gulp-git-sftp'),
    cnf = require('../config/cnf'),
    argv = require('yargs').argv,
    gulp = require('gulp'),
    CNF = ggs.cnf(cnf);
 
var FTP = ggs.ftp(CNF);
 
exports.task = function() {
    
    console.log('CNF:', CNF)
 
    var conn = FTP.conn({
        user: argv.user || CNF.user,
        pass: argv.pass || CNF.pass,
        host: argv.host || CNF.host,
    });
    
    var files = argv.f;
        
    if (!files) return;
    
    files = FTP._file2format( files.split(',') );
    console.log('files:', files)
    
    ggs.git({
        conn: conn,
        files: files,
        basePath: CNF.basePath,
        remotePath: CNF.remotePath,
    }, function(err) {
        if (err) console.log('ERRROR2:', err);
        console.log('Files from -f to FTP is deployed!!!')
        return true;
    });
};
