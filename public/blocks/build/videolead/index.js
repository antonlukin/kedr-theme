!function(){"use strict";function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}function t(t,n,r){return(n=function(t){var n=function(t,n){if("object"!==e(t)||null===t)return t;var r=t[Symbol.toPrimitive];if(void 0!==r){var o=r.call(t,"string");if("object"!==e(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return String(t)}(t);return"symbol"===e(n)?n:String(n)}(n))in t?Object.defineProperty(t,n,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[n]=r,t}var n=window.wp.element,r=window.wp.i18n,o=window.wp.plugins,i=window.wp.editPost,u=window.wp.components,l=window.wp.data,a=function(e){var o=e.metaKey,a=(0,l.useSelect)((function(e){return e("core/editor").getEditedPostAttribute("format")})),d=(0,l.useSelect)((function(e){return e("core/editor").getEditedPostAttribute("meta")})),c=(0,l.useDispatch)("core/editor",[d]).editPost;return(0,n.createElement)(n.Fragment,null,"video"===a&&(0,n.createElement)(i.PluginDocumentSettingPanel,{name:"kedr-videolead-panel",title:(0,r.__)("Описание видео","kedr-theme")},(0,n.createElement)(u.TextareaControl,{label:(0,r.__)("Альтернативный лид","kedr-theme"),help:(0,r.__)("Текст будет отображаться в виджете","kedr-theme"),value:d[o],onChange:function(e){c({meta:t({},o,e)})}})))};(0,o.registerPlugin)("kedr-theme-videolead",{render:function(){var e;return(0,n.createElement)(a,{metaKey:null===(e=window.kedr_theme_videolead)||void 0===e?void 0:e.meta})}})}();