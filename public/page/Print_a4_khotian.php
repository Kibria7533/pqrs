<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <title>Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        @font-face {
            font-family: "kalpurush";
            src: url("./../fonts/kalpurush/kalpurush-kalpurush.eot");
            src: url("./../fonts/kalpurush/kalpurush-kalpurush.woff") format("woff"),
            url("./../fonts/kalpurush/kalpurush-kalpurush.ttf") format('truetype'),
            url("./../fonts/kalpurush/kalpurush-kalpurush.svg#filename") format("svg");
        }
        .tablesorter{
            font-size:16px;
            text-align:left;
            font-family: "kalpurush",Tahoma, Geneva, sans-serif;
        }
        html, body, div, table, tr, td, th, span, p{
            font-family: "kalpurush",Tahoma, Geneva, sans-serif;
        }
        table tr thead th{
            background-color: #fff;
            border: 1px #D9D9D9 solid;
            font-size: 13px;
            font-family: "kalpurush", sans-serif;
        }
        table tr td{
            font-size: 13px;
            font-family: "kalpurush", sans-serif;
        }
        table{
            border-spacing: 0;
            table-layout: fixed;
            width: 100%;
        }
        #print_button{
            display: none;
        }
        a{
            display: none!important;
        }
        @media print{
            @page {
                size: landscape;
                margin-left: 3.5cm;
            }
        }

    </style>

</head>
<body style="margin-left: 10px; margin-right: 10px; background-color: transparent;">
<table cellpadding="0" cellspacing="0" border="0">
    <!--        <table cellpadding="0" cellspacing="0" width="1000" border="0" align="left">-->
    <tr>
        <td valign="top" align="center">
            <script language="javascript">
                try{
                    if(parent.window.opener != null && !parent.window.opener.closed)
                    {
                        varele1= parent.window.opener.document.getElementById("<?php echo $_REQUEST['selLayer']; ?>");
                        text=varele1.innerHTML;
                        document.write(text);
                        text=document;
                        print(text);
                    }

                }catch(e){ alert("Parent window is undefined");}
            </script>
        </td>
    </tr>
</table>
<script>
    /*$("#ReportTable").attr("border","1");
    $("#ReportTable").attr("cellpadding","3");
    $("#ReportTable").attr("cellspacing","0");
    $("#ReportTable").attr("style","border-collapse: collapse");
    $("#ReportTable tr").attr("style","display: show");*/
</script>
</body>
</html>
