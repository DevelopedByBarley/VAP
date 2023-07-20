CKEDITOR.plugins.add( 'oldalak',
{   
   requires : ['richcombo'], //, 'styles' ],
   init : function( editor )
   {
      var config = editor.config,
         lang = editor.lang.format;
  
	var tags = [];
	var i = 0;
	
	$.ajax({
		url: "/admin/__ckeditor_oldalak_lista_dropdown.php",
		cache: false,
		async : true,
		dataType: 'json',
		success: function(result){
			$.each(result, function(x, obj){
			tags[i] = [obj.tokenVal, obj.tokenDsp, obj.tokenDesc];
			i++;
		});
		}
	});	  


      // Create style objects for all defined styles.

      editor.ui.addRichCombo( 'oldalak',
         {
            label : "Oldalak",
            title :"Oldalak",
            voiceLabel : "Oldalak",
            className : 'cke_format',
            multiSelect : false,
			toolbar: 'gde',

            panel :
            {
			   css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
               voiceLabel : lang.panelVoiceLabel
            },

            init : function()
            {
               this.startGroup( "oldalak" );
               //this.add('value', 'drop_text', 'drop_label');
               for (var this_tag in tags){
                  this.add("<a href=" + tags[this_tag][0] +">"+ tags[this_tag][2] +"</a>", tags[this_tag][1], tags[this_tag][2]);
               }
            },

            onClick : function( value )
            {         
               editor.focus();
               editor.fire( 'saveSnapshot' );
               editor.insertHtml(value);
               editor.fire( 'saveSnapshot' );
            }
         });
   }
});