<script language="JavaScript" type="text/javascript">
/*function storeCaret(text)
{ // voided
}
*/
function AddText(startTag,defaultText,endTag) 
{
   with(document.poster)
   {
      if (description.createTextRange) 
      {
         var text;
         description.focus(description.caretPos);
         description.caretPos = document.selection.createRange().duplicate();
         if(description.caretPos.text.length>0)
         {
            //g�re les espace de fin de s�lection. Un double-click s�lectionne le mot
            //+ un espace qu'on ne souhaite pas forc�ment...
            var sel = description.caretPos.text;
            var fin = '';
            while(sel.substring(sel.length-1, sel.length)==' ')
            {
               sel = sel.substring(0, sel.length-1)
               fin += ' ';
            }
            description.caretPos.text = startTag + sel + endTag + fin;
         }
         else
            description.caretPos.text = startTag+defaultText+endTag;
      }
      else description.value += startTag+defaultText+endTag;
   }
}
</script>
