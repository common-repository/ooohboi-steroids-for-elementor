/* Elementor hooks - editor - frontend */

'use strict';

( function ( $, w ) {
    
    var $window = $( w );

    $window.on( 'elementor/frontend/init', function() {

        var PoopArt = elementorModules.frontend.handlers.Base.extend( {

            onInit: function() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.widgetContainer = this.$element.find( '.elementor-widget-container' )[ 0 ];
                this.initPoopArt();

            },

            initPoopArt: function() {

                if ( this.isEdit ) this.$element.addClass( 'ob-has-background-overlay' );

            }, 

        } );

        var Harakiri = elementorModules.frontend.handlers.Base.extend( {

            onInit: function onInit() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.initHarakiri();

            },

            initHarakiri: function() {

                if( this.isEdit ) this.$element.addClass( 'ob-harakiri' );

            }, 

        } );

        var handlersList = {

            'widget': PoopArt, 
            'heading.default': Harakiri, 
            'text-editor.default': Harakiri, 

        };

        $.each( handlersList, function( widgetName, handlerClass ) {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widgetName, function( $scope ) {
                
                elementorFrontend.elementsHandler.addHandler( handlerClass, { $element: $scope } );

            } );

        } );

    } );

} ( jQuery, window ) );