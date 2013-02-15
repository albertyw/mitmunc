/*
 * When this script is called, it checks the url to make sure that the page is encrypted.  If not, it redirects to encryption
 * Note that pages that call this are going to be loaded in whatever (non)encryption they were requested in.  This script only makes sure that further links are correct
 * @author albertyw@mit.edu
 */
var currenturl = location.href
if(currenturl.indexOf('https')==-1){
    window.location = currenturl.replace('http','https')
}

