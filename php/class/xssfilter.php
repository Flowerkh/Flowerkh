function XSSfilter($str) {
  $filstr="javascript,vbscript,expression,applet,meta,xml,blink,script,embed,object,frameset,ilayer,layer,bgsound,base,eval,innerHTML,charset,document,string,create,append,binding,alert,msgbox,refresh,embed,ilayer,applet,cookie,javascript,void,onabort,onactivae,onafterprint,onafterupdate,onbefore,onbeforeactivate,onbeforecopy,onbeforecut,onbeforedeactivate,onbeforeeditfocus,onbeforepaste,onbeforeprint,onbeforeunload,onbeforeupdate,onblur,onbounce,oncellchange,onchange,onclick,oncontextmenu,oncontrolselect,oncopy,oncut,ondataavailable,ondatasetchanged,ondatasetcomplete,ondblclick,ondeactivate,ondrag,ondragend,ondragenter,ondragleave,ondragover,ondragstart,ondrop,onerror,onerrorupdate,onfilterchange,onfinish,onfocus,onfocusin,onfocusout,onhelp,onkeydown,onkeypress,onkeyup,onlayoutcomplete,onload,onlosecapture,onmousedown,onmouseenter,onmouseleave,onmousemove,onmouseout,onmouseover,onmouseup,onmousewheel,onmove,onmoveend,onmovestart,onpaste,onpropertychange,onreadystatechange,onreset,onresize,onresizeend,onresizestart,onrowenter,onrowexit,onrowsdelete,onrowsinserted,onscroll,onselect,onselectionchange,onselectstart,onstart,onstop,onunload";
  $str = htmlspecialchars_decode($str);

  if ($filstr != "") {
    $otag = explode (",", $filstr);

    for ($i = 0;$i < count($otag);$i++) {
      $str = eregi_replace($otag[$i], "_".$otag[$i]."_", $str);
    }
  }
  return htmlspecialchars($str);
}
