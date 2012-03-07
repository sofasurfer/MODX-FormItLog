FormItLog Extra for MODx Revolution
=================================
**Author: Kilian Bohnenblust <kilian@sofasurfer.ch>**

- Hook for FormIt Extra to store posted data in a jSon file.
- Simple MODX manager to list and edit posted data.

Installation
============

- Install via Package manager (Download Extras -> Search Locally for Packages)


Documentation
=============

To store FormIt posted data simplye add the **FormItLog** hook to your snippet call. 

<pre>
[[!FormIt?
   &hooks=`spam,FormItLog,email,redirect`
   &logfile=`[[++formitlog.logfile]]`
   &emailTo=`[[++emailsender]]`
   &emailUseFieldForSubject=`1`
   &successMessage=`Thank You!`
   &validate=`name:required,
      text:required,
      email:email:required,
      workemail:blank`
]]
</pre>

Please see the official documentation at:
http://modx.sofasurfer.org/showcase/formitlog/