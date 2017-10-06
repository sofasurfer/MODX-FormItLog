FormItLog Extra for MODx Revolution
=================================
**Author: Kilian Bohnenblust <kilian@sofasurfer.ch>**

- Hook for FormIt Extra to store all posted form data in a jSon file.
- Simple MODX manager to list and edit posted data.
- CVS export functionality

Installation
============

- Install via Package manager
- Or download from MODX extra page: https://modx.com/extras/package/formitlog

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

For **security** reason it's recommended to add the following rule to your .htaccess file, so the log file can't be read from the web.
<pre>

# to protect formit log file 
&lt;Files formitlog.json &gt;
	order allow,deny
	deny from all
&lt;/Files&gt;

</pre>
