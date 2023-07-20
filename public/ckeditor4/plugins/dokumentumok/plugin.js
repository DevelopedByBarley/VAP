CKEDITOR.plugins.add( 'dokumentumok',
{   
   requires : ['richcombo'], //, 'styles' ],
   init : function( editor )
   {
      var config = editor.config,
         lang = editor.lang.format;

	var tags_doks = [];
	var i = 0;
	$.ajax({
		url: "/admin/__ckeditor_doks_lista_dropdown.php",
		cache: false,
		async : true,
		dataType: 'json',
		success: function(result){
			$.each(result, function(x, obj){
			tags_doks[i] = [obj.tokenVal, obj.tokenDsp, obj.tokenDesc];
			i++;
		});
		}
	});	  


      // Create style objects for all defined styles.

      editor.ui.addRichCombo( 'Dokumentumok',
         {
            label : "Dokumentumok",
			   toolbar: 'gde',
            title :"dokumentumok",
            voiceLabel : "dokumentumok",
            className : 'cke_format',
            multiSelect : false,

            panel :
            {
//               css : [ config.contentsCss, CKEDITOR.getUrl( editor.skinPath + 'editor.css' ) ],
				css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
               voiceLabel : lang.panelVoiceLabel
            },

            init : function()
            {
               this.startGroup( "Dokumentumok" );
               //this.add('value', 'drop_text', 'drop_label');
               for (var this_tag in tags_doks){
                  this.add("<a href=" + tags_doks[this_tag][0] +">"+ tags_doks[this_tag][1] +"</a>", tags_doks[this_tag][1], tags_doks[this_tag][1]);
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