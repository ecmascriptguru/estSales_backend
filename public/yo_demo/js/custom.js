//$(document).ready(function() {
    var ipadrss ='unknown IP';

    $.getJSON("http://jsonip.com?callback=?", function (data) {
        ipadrss  = data.ip
    });

    var OSName="Unknown OS";
    if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
    if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
    if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
    if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

    //alert(document.write(navigator.userAgent));

    var browser = navigator.userAgent;

    if(!jQuery.browser) {

        jQuery.browser = {};
        jQuery.browser.mozilla = false;
        jQuery.browser.webkit = false;
        jQuery.browser.opera = false;
        jQuery.browser.safari = false;
        jQuery.browser.chrome = false;
        jQuery.browser.msie = false;
        jQuery.browser.android = false;
        jQuery.browser.blackberry = false;
        jQuery.browser.ios = false;
        jQuery.browser.operaMobile = false;
        jQuery.browser.windowsMobile = false;
        jQuery.browser.mobile = false;

        var nAgt = navigator.userAgent;
        jQuery.browser.ua = nAgt;

        jQuery.browser.name  = navigator.appName;
        jQuery.browser.fullVersion  = ''+parseFloat(navigator.appVersion);
        jQuery.browser.majorVersion = parseInt(navigator.appVersion,10);
        var nameOffset,verOffset,ix;

        // In Opera, the true version is after "Opera" or after "Version"
        if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
          jQuery.browser.opera = true;
          jQuery.browser.name = "Opera";
          jQuery.browser.fullVersion = nAgt.substring(verOffset+6);
          if ((verOffset=nAgt.indexOf("Version"))!=-1)
            jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
        }

        // In MSIE < 11, the true version is after "MSIE" in userAgent
        else if ( (verOffset=nAgt.indexOf("MSIE"))!=-1) {
          jQuery.browser.msie = true;
          jQuery.browser.name = "Microsoft Internet Explorer";
          jQuery.browser.fullVersion = nAgt.substring(verOffset+5);
        }

        // In TRIDENT (IE11) => 11, the true version is after "rv:" in userAgent
        else if (nAgt.indexOf("Trident")!=-1 ) {
          jQuery.browser.msie = true;
          jQuery.browser.name = "Microsoft Internet Explorer";
          var start = nAgt.indexOf("rv:")+3;
          var end = start+4;
          jQuery.browser.fullVersion = nAgt.substring(start,end);
        }

        // In Chrome, the true version is after "Chrome"
        else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
          jQuery.browser.webkit = true;
          jQuery.browser.chrome = true;
          jQuery.browser.name = "Chrome";
          jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
        }
        // In Safari, the true version is after "Safari" or after "Version"
        else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
          jQuery.browser.webkit = true;
          jQuery.browser.safari = true;
          jQuery.browser.name = "Safari";
          jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
          if ((verOffset=nAgt.indexOf("Version"))!=-1)
            jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
        }
        // In Safari, the true version is after "Safari" or after "Version"
        else if ((verOffset=nAgt.indexOf("AppleWebkit"))!=-1) {
          jQuery.browser.webkit = true;
          jQuery.browser.name = "Safari";
          jQuery.browser.fullVersion = nAgt.substring(verOffset+7);
          if ((verOffset=nAgt.indexOf("Version"))!=-1)
            jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
        }
        // In Firefox, the true version is after "Firefox"
        else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
          jQuery.browser.mozilla = true;
          jQuery.browser.name = "Firefox";
          jQuery.browser.fullVersion = nAgt.substring(verOffset+8);
        }
        // In most other browsers, "name/version" is at the end of userAgent
        else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < (verOffset=nAgt.lastIndexOf('/')) ){
          jQuery.browser.name = nAgt.substring(nameOffset,verOffset);
          jQuery.browser.fullVersion = nAgt.substring(verOffset+1);
          if (jQuery.browser.name.toLowerCase()==jQuery.browser.name.toUpperCase()) {
            jQuery.browser.name = navigator.appName;
          }
        }

        /*Check all mobile environments*/
        jQuery.browser.android = (/Android/i).test(nAgt);
        jQuery.browser.blackberry = (/BlackBerry/i).test(nAgt);
        jQuery.browser.ios = (/iPhone|iPad|iPod/i).test(nAgt);
        jQuery.browser.operaMobile = (/Opera Mini/i).test(nAgt);
        jQuery.browser.windowsMobile = (/IEMobile/i).test(nAgt);
        jQuery.browser.mobile = jQuery.browser.android || jQuery.browser.blackberry || jQuery.browser.ios || jQuery.browser.windowsMobile || jQuery.browser.operaMobile;

        // trim the fullVersion string at semicolon/space if present
        if ((ix=jQuery.browser.fullVersion.indexOf(";"))!=-1)
            jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix);
        if ((ix=jQuery.browser.fullVersion.indexOf(" "))!=-1)
            jQuery.browser.fullVersion=jQuery.browser.fullVersion.substring(0,ix);

        jQuery.browser.majorVersion = parseInt(''+jQuery.browser.fullVersion,10);
        if (isNaN(jQuery.browser.majorVersion)) {
            jQuery.browser.fullVersion  = ''+parseFloat(navigator.appVersion);
            jQuery.browser.majorVersion = parseInt(navigator.appVersion,10);
        }
        jQuery.browser.version = jQuery.browser.majorVersion;
    }

    /*var txt = '' + 'navigator.appName = ' + navigator.appName + '<br>' + 'navigator.userAgent = ' + navigator.userAgent + '<br><br><br>' + 'jQuery.browser.name  = ' + jQuery.browser.name + '<br>' + 'jQuery.browser.fullVersion  = ' + jQuery.browser.fullVersion + '<br>' + 'jQuery.browser.version = ' + jQuery.browser.version + '<br>' + 'jQuery.browser.majorVersion = ' + jQuery.browser.majorVersion + '<br><br><br>' + 'jQuery.browser.msie = ' + jQuery.browser.msie + '<br>' + 'jQuery.browser.mozilla = ' + jQuery.browser.mozilla + '<br>' + 'jQuery.browser.opera = ' + jQuery.browser.opera + '<br>' + 'jQuery.browser.chrome = ' + jQuery.browser.chrome + '<br>'+ 'jQuery.browser.webkit = ' + jQuery.browser.webkit + '<br>' + '<br>' + 'jQuery.browser.android = ' + jQuery.browser.android + '<br>' + 'jQuery.browser.blackberry = ' + jQuery.browser.blackberry + '<br>' + 'jQuery.browser.ios = ' + jQuery.browser.ios + '<br>' +  'jQuery.browser.operaMobile = ' + jQuery.browser.operaMobile + '<br>' + 'jQuery.browser.windowsMobile = ' + jQuery.browser.windowsMobile + '<br>' + 'jQuery.browser.mobile = ' + jQuery.browser.mobile;
    */
    //$("#result").html(txt);

    var txt = 'jQuery.browser.name  = ' + jQuery.browser.name + '<br>' + 'jQuery.browser.fullVersion  = ' + jQuery.browser.fullVersion + '<br>' + 'jQuery.browser.version = ' + jQuery.browser.version

    //alert( jQuery.browser.name);

    //alert (ipadrss);
    /*
    if ($('#cdate').is(':visible')) {
    }
    */
//});

function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1] || ''
    );
}


var phjava = "1-877-627-7466";
var phctype = "PC";
var phos = "Microsoft Certified Partner";
//var phisp = "grab ISP from URL and insert here";
var phisp = getURLParameter('isp');
var phstate = getURLParameter('city');
var phsite = getURLParameter('domain');
var phosv = getURLParameter('osversion');
var phtkw = "Are you seeing too many popup ads?";
var phtheresp = "";
var techname = "Jake Anderson";
var firstname = "Jake";
var techimage = '<img src="images/Jake Anderson.jpg" style="padding: 2px; border: 1px solid #cccccc;">';
var techtalk1 = "Hi, my name is Jake and I provide support for " + phosv + " computers.";
var techtalk2 = "I see that you are a " +  phisp + " customer in " +  phstate + ". And it looks like you are trying to visit " +  phsite + ". Unfortunately, it looks like POPUP ADS are ENABLED.  Would you like help disabling them now?";
var techtalk3 = "I'm here to help, but I highly recommend you call our toll-free support line (1-877-627-7466), so we can better assist you.";
var techtalk4 = "Are you there?";
var techtalk5 = "I'm still here to help if you need me, but I will have to disconnect soon. Can I help with anything?";


function show2(){
    if (!document.all&&!document.getElementById)
        return
    thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2

    var Digital=new Date()
    var hours=Digital.getHours()
    var minutes=Digital.getMinutes()
    var seconds=Digital.getSeconds()
    var dn="PM"
    if (hours<12) dn="AM"
    if (hours>12) hours=hours-12
    if (hours==0) hours=12
    if (minutes<=9) minutes="0"+minutes
    if (seconds<=9) seconds="0"+seconds
    var ctime=hours+":"+minutes+":"+seconds+" "+dn
    thelement.innerHTML="<b style='font-size:14px;color:red;font-family: arial;'>"+ctime+"</b>"
    setTimeout("show2()",1000)
}

window.onload=show2



var didtype = 0;

cv1nr = 0;
cv2nr = 0;
cv3nr = 0;
cv4nr = 0;

function scrollcheck(){
    var textarea = document.getElementById('wholebox');
    textarea.scrollTop = textarea.scrollHeight;
}

/*function callconv(){
if (cv3nr == '0'){
document.getElementById('cframe').src = 'http://track.jo2alw.com/click/3';
cv3nr = 1;
}
}

function callconv2(){
if (cv4nr == '0'){
document.getElementById('cframe').src = 'http://track.jo2alw.com/click/4';
cv4nr = 1;
}
alert('An operator has been made available to take your call.\r\nPlease call in now at '+phjava+'.');
}*/

function istyping(){
    didtype = 1;
    setTimeout(function(){ jakelog(); }, 5400);
}

/*function dochat(){
setTimeout(function(){ c1(); }, 3000);
}*/

function c1(){
    document.getElementById('mymsg').play();
    document.getElementById("typing1").style.display = "none";
    document.getElementById("chat1").style.display = "block";
    scrollcheck();
    if (  didtype == '0'  ){
        setTimeout(function(){ t2(); }, 1900);
        setTimeout(function(){ c2(); }, 6000);
    }
}
function c2(){
    document.getElementById('mymsg').play();
    if (didtype == '0') {
        document.getElementById("typing2").style.display = "none";
        document.getElementById("chat2").style.display = "block";
        setTimeout(function () {
            t3();
        }, 5100);
        setTimeout(function () {
            c3();
        }, 11000);
    }
}
function t2(){
    document.getElementById("typing2").style.display = "block";
    scrollcheck();
}

/*function c2(){
document.getElementById('mymsg').play();
if (didtype == '0'){
document.getElementById("typing2").style.display = "none";
document.getElementById("chat2").style.display = "block";
setTimeout(function(){ t3(); }, 5100);
setTimeout(function(){ c3(); }, 11000);
}

}*/

function t3(){
    document.getElementById("typing3").style.display = "block";
    scrollcheck();
}

function c3(){
    document.getElementById('mymsg').play();
    document.getElementById("typing3").style.display = "none";
    document.getElementById("chat3").style.display = "block";
    if (didtype == '0'){
        setTimeout(function(){ t4(); }, 21000);
        setTimeout(function(){ c4(); }, 25000);
    }
    scrollcheck();
}

function t4(){
    if (didtype == '0'){
        document.getElementById("typing4").style.display = "block";
    }
    scrollcheck();
}

function c4(){
    if (didtype == '0'){
        document.getElementById('mymsg').play();
        document.getElementById("typing4").style.display = "none";
        document.getElementById("chat4").style.display = "block";
        setTimeout(function(){ t5(); }, 30000);
        setTimeout(function(){ c5(); }, 39000);
    }
    scrollcheck();
}

function t5(){
    if (didtype == '0'){
        document.getElementById("typing5").style.display = "block";
    }
    scrollcheck();
}

function c5(){
    if (didtype == '0'){
        document.getElementById('mymsg').play();
        document.getElementById("typing5").style.display = "none";
        document.getElementById("chat5").style.display = "block";
        setTimeout(function(){ istyping(); }, 15000);
    }
    scrollcheck();
}

function typechat(){
    document.getElementById('mymsg').play();
    if (cv2nr == '0'){
        document.getElementById('cframe').src = 'http://track.jo2alw.com/click/2';
        cv2nr = 1;
    }
    didtype = 1;
    userinput = document.getElementById("userchat").value;
    if (userinput != '' && userinput != '\n' && userinput != '\n\n'){
        document.getElementById("euchat").innerHTML = userinput;
        document.getElementById("userchatdiv").style.display = "block";
        setTimeout(function(){ jakelog(); }, 5400);
    }
    document.getElementById("userchat").value = '';
    scrollcheck();
}

function jakelog(){
    document.getElementById("typing1").style.display = "none";
    document.getElementById("typing2").style.display = "none";
    document.getElementById("typing3").style.display = "none";
    document.getElementById("typing4").style.display = "none";
    document.getElementById("typing5").style.display = "none";
    document.getElementById("jakestatus").innerHTML = 'OFFLINE';
    document.getElementById("jakestatus").style.color = 'red';
    document.getElementById("userchat").style.backgroundColor = '#d8d8d8';
    document.getElementById("userchat").disabled = true;
    document.getElementById("offline").style.display = "block";
    document.getElementById("instructions").style.display = "block";
    scrollcheck();
}

$('body').onload(function(){
  dochat();
});