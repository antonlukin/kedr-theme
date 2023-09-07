!function(){"use strict";var e=window.wp.blocks,t=window.wp.blockEditor;function r(e){return r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},r(e)}function o(e,t,o){return(t=function(e){var t=function(e,t){if("object"!==r(e)||null===e)return e;var o=e[Symbol.toPrimitive];if(void 0!==o){var n=o.call(e,"string");if("object"!==r(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return String(e)}(e);return"symbol"===r(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:o,enumerable:!0,configurable:!0,writable:!0}):e[t]=o,e}var n=window.wp.element,c=window.wp.i18n,i=window.wp.components;function l(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function a(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}(0,e.registerBlockType)("kedr/help",{edit:(0,t.withColors)("backgroundColor")((function(e){var r,a,u=[];null!==(r=e.backgroundColor)&&void 0!==r&&r.class&&u.push(e.backgroundColor.class),null!==(a=e.attributes)&&void 0!==a&&a.italic&&u.push("has-italic-font");var s=(0,t.useBlockProps)({className:u.join(" ")});return(0,n.createElement)(n.Fragment,null,(0,n.createElement)(t.InspectorControls,null,(0,n.createElement)(t.PanelColorSettings,{title:(0,c.__)("Настройки цветов","kedr-theme"),colorSettings:[{value:e.backgroundColor.color,onChange:e.setBackgroundColor,label:(0,c.__)("Цвет фона блока","kedr-theme")}]}),(0,n.createElement)(i.PanelBody,{title:(0,c.__)("Настойки отображения","kedr-theme")},(0,n.createElement)(i.PanelRow,null,(0,n.createElement)(i.ToggleControl,{label:(0,c.__)("Использовать курсив","kedr-theme"),checked:e.attributes.italic,onChange:function(t){return e.setAttributes({italic:t})}})))),(0,n.createElement)("div",function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?l(Object(r),!0).forEach((function(t){o(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({},s),(0,n.createElement)(t.RichText,{tagName:"p",onChange:function(t){e.setAttributes({content:t})},allowedFormats:["core/bold","core/link","kedr/reference"],value:e.attributes.content,placeholder:(0,c.__)("Введите текст справки","kedr-theme")})))})),save:function(e){var r=[],c=(0,t.getColorClassName)("background-color",e.attributes.backgroundColor);c&&r.push(c),e.attributes.italic&&r.push("has-italic-font");var i=t.useBlockProps.save({className:r.join(" ")});return(0,n.createElement)("div",function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?a(Object(r),!0).forEach((function(t){o(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):a(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({},i),(0,n.createElement)(t.RichText.Content,{tagName:"p",value:e.attributes.content}))}})}();