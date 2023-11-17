# LogosCorp Magento 2 - Content Security Policy Module

[![N|Solid](https://cdn.logoscorp.com/logos/logo_logoscorp_color.svg)](https://www.logoscorp.com)

Este modulo soluciona los problemas de content policy reportado por los navegadores en  Magento 2.3.5-p2

# Reomendaciones!

  - En caso de necesitar mas URL en los white list, es recomendable hacer push para mantener este repo al dia.
  
### Proceso de Instalación

Los siguientes comandos deben ser ejecutados dentro de root folder del proyecto.

```sh
$ cd app/code/Logoscorp
$ git clone git@bitbucket.org:logoscorp/logoscorp-csp.git
$ mv logoscorp-csp Csp
```

Luego debemos volver al root del proyecto y ejecutar.

```sh
$ bin/magento module:enable Logoscorp_Csp
$ bin/magento setup:upgrade
$ bin/magento c:f
```

Listo, los errores de la consola deberian de desaparecer. Si los mismos persisten, limpia el cache de tu navegador y revisa que las URL reportadas esten en el archivo etc/csp_whitelist.xml
