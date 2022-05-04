ARG MW_VERSION=1.35
FROM gesinn/docker-mediawiki-sqlite:${MW_VERSION}

ARG CHAMELEON_VERSION=4.1.0
RUN COMPOSER=composer.local.json composer require --no-update mediawiki/chameleon-skin ${CHAMELEON_VERSION} && \
    sudo -u www-data composer update

COPY . /var/www/html/extensions/ConfIDentSkin

RUN echo \
        "wfLoadExtension( 'Bootstrap' );\n" \
        "wfLoadSkin( 'chameleon' );\n" \
        "wfLoadExtension( 'ConfIDentSkin' );\n" \
    >> LocalSettings.php \
