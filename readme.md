## Installation de Bootstrap CSS

```
composer require symfony/asset-mapper symfony/asset symfony/twig-pack
symfony console importmap:require bootstrap
symfony console importmap:install
```

Puis ajouter les lignes suivantes dans le fichier "assets/bootstrap.js" :
```
import 'bootstrap/dist/css/bootstrap.min.css';
import '@popperjs/core';
import 'bootstrap';
```

Vérifier dans le fichier "base.html.twig" que l'appel du JS se fait :
```
{% block javascripts %}
{% block importmap %}{{ importmap('app') }}{% endblock %}
{% endblock %}
```