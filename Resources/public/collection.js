/**
 * Plugin jQuery pour la prise en charge du formulaire de type collection
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 */

;(function ($, window, undefined) {

    $.olixCollection = function(element, options) {
        
        var defaults = {
            allow_add: false,
            allow_delete: false
        };
        
        plugin = this;
        
        this.options = $.extend({}, defaults, options);
        
        this.$element = $(element);
        this.element = element;
        
        this.init();
    };



    $.olixCollection.prototype = {
    
        /**
         * Initialisation du plugin
         */
        init : function() {
            console.log(plugin.options);
            console.log(this.element.id); console.log(this.$element.data('prototype'));
            
            // Evènement du bouton 'ajout'
            if (this.options.allow_add) {
                this.nextId = this.$element.children('.collection').children('div').length;
                this.$element.find('.actions > .insert').click(function(e) {
                    e.preventDefault();
                    plugin.addItem($(this));
                });
            }
            
            // Evènement sur les boutons 'delete'
            if (this.options.allow_delete) {
                this.$element.find('fieldset.olix-collection-item > .actions > .delete').click(function(e) {
                    e.preventDefault();
                    plugin.deleteItem($(this));
                });
            }
            
            // Pouvoir trier la collection
            if (this.options.sortable) {
                this.$element.children('.collection').sortable({
                    placeholder: "olix-collection-sortable-highlight",
                    forcePlaceholderSize: true,
                    update: function(e, ui) {
                        plugin.changeSorting();
                    }
                });
            }
        },
        
        
        /**
         * Ajout d'un élément à la collection
         * 
         * @param $elt : Element du bouton 'ajout'
         */
        addItem: function($elt) {
            // Récupère l'élément ayant l'attribut data-prototype
            var newItem = this.$element.data('prototype');
            // Remplace '__name__' dans le HTML du prototype par un nombre basé sur la longueur de la collection courante
            newItem = newItem.replace(/__name__/g, this.nextId);
            $newItem = $(newItem);
            
            // Ajoute l'élément
            this.$element.children('.collection').append($newItem);
            if (this.options.sortable) this.changeSorting();
            
            // Prise en charge du bouton 'delete'
            if (this.options.allow_delete) {
                $newItem.find('.delete').click(function(e) {
                    e.preventDefault();
                    plugin.deleteItem($(this));
                });
            }
            
            this.nextId++;
        },
        
        
        /**
         * Suppression d'un élément de la collection
         * 
         * @param $elt :Elément du bouton 'delete' selectionné
         */
        deleteItem: function($elt) {
            if (confirm('Veux tu enlever cet élément ?')) {
                $elt.closest('fieldset.olix-collection-item').remove();
                if (this.options.sortable) this.changeSorting();
            }
        },
        
        
        /**
         * Sur changement de tri, modifie le champs de tri spécifié dans 'sortable_field'
         */
        changeSorting: function() {
            console.log('update sorting');
            $('[id^="'+this.element.id+'_"][id$="'+this.options.sortable_field+'"]').each(function(i){
                console.log(this);
                $(this).val(i);
            });
        }
    
    }



    $.fn.olixCollection = function (options) {
        
        // Initialisation avec ou sans options
        if (options === undefined || typeof options === 'object') {
            return this.each(function() {
                // Si le plugin n'a pas été assigné
                if ($.data(this, 'olixCollection') == undefined) {
                    // on créé un instance
                    var plugin = new $.olixCollection(this, options);
                    // on stocke la référence du plugin
                    $.data(this, 'olixCollection', plugin);
                }
            });
        }
        
    }

}(jQuery, window));