var ggs = require('gulp-git-sftp'),
    cnf = require('../config/cnf'),
    argv = require('yargs').argv,
    gulp = require('gulp'),
    CNF = ggs.cnf(cnf);
 
var FTP = ggs.ftp(CNF);
 
module.exports = function() {
    
    console.log('CNF:', CNF)
    
    var conn = FTP.conn({
        user: argv.user || CNF.user,
        pass: argv.pass || CNF.pass,
        host: argv.host || CNF.host,
    });
 
    ggs.git({
        conn: conn,
        basePath: CNF.basePath,
        remotePath: CNF.remotePath,
    }, function(err) {
        if (err) console.log('ERRROR2:', err);
        console.log('Files from git to FTP is deployed!!!')
        return true;
    });
};