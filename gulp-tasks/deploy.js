var cnf = require('../config/cnf'),
    argv = require('yargs').argv,
    gulp = require('gulp'),
    $ = require('gulp-load-plugins')({
        rename: {
            'gulp-git-sftp': 'ggs',
        }
    }),
    CNF = $.ggs.cnf(cnf);
 
var FTP = $.ggs.ftp(CNF);

exports.task = function() {
    
    console.log('CNF:')
    console.log('CNF:', CNF)
        
    var conn = FTP.conn({
        user: argv.user || CNF.user,
        pass: argv.pass || CNF.pass,
        host: argv.host || CNF.host,
    });
     
    if (!argv.del) {
        return gulp.src( ['./**/*', '!node_modules{,/**}', '!bower{,/**}', '!bower_components{,/**}', '**/.htaccess'], { base: CNF.basePath, buffer: false } )
            .pipe( $.rename(function(fname) {
                console.info('fname:', fname.basename, fname.extname);
            }))
            .pipe( conn.newer( CNF.remotePath || argv.remotePath ) ) // only upload newer files  
            .pipe( conn.dest( CNF.remotePath || argv.remotePath ) );
    } else {
        // conn.delete(CNF.remotePath+'dd', function(e) { 
        return conn.rmdir(CNF.remotePath, function(e) {
            console.log('deleted:', CNF.remotePath);
        });
    }
};
 
// BUILD TASKS