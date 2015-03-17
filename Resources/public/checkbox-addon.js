/**
 * Plugin jQuery pour la prise en charge du formulaire de type checkbox addon
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 */

;(function ($, window, undefined) {

    $.olixCheckboxAddon = function(element, options) {
        
        var defaults = {
            enabled: false
        };
        
        plugin = this;
        
        this.options = $.extend({}, defaults, options);
        
        this.$element = $(element);
        this.element = element;
        
        this.init();
    };



    $.olixCheckboxAddon.prototype = {
    
        /**
         * Initialisation du plugin
         */
        init : function() {
            var that = this;
            
            // Recupère les DOM
            this.checkbox = this.$element.children('span').children('input[type="checkbox"]');
            this.widget = $("#"+this.element.id.substr(0, this.element.id.length-6));
            
            // Evènement sur click du checkbox
            if (this.options.enabled) {
        	this.checkbox.prop('checked', true);
        	this.widget.prop('disabled', false);
            } else {
        	this.checkbox.prop('checked', false);
        	this.widget.prop('disabled', true);
            }
            
            this.checkbox.click(function(e) {
        	that.toggle();
            });
        },
        
        
        /**
         * Permute l'activation ou pas du widget
         */
        toggle : function() {
            if (this.checkbox.prop('checked'))
        	this.widget.prop('disabled', false);
            else
        	this.widget.prop('disabled', true);
        }
        
    }



    $.fn.olixCheckboxAddon = function (options) {
        
        // Initialisation avec ou sans options
        if (options === undefined || typeof options === 'object') {
            return this.each(function() {
                // Si le plugin n'a pas été assigné
                if ($.data(this, 'olixCheckboxAddon') == undefined) {
                    // on créé un instance
                    var plugin = new $.olixCheckboxAddon(this, options);
                    // on stocke la référence du plugin
                    $.data(this, 'olixCheckboxAddon', plugin);
                }
            });
        }
        
    }

}(jQuery, window));