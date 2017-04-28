Project Outline
----------------

Project Goals
'''''''''''''

1. Expose certain limited metrics about a store for use in diagnosing an issue
2. Provide a model to extend the metrics exposed to write arbitrary additional metrics to the endpoint

This project is intended to make it easier to introspect one, or several running Magento stores.

Scope
"""""

All metrics should be collected on a per-instance basis, rather than for the health of a service overall. That should be calculated by querying the aggregate of all such collections.

Similar Work
''''''''''''

The author understand that there is little other work of this type.

Justification
'''''''''''''

With more recent developments in infrastructure, such as Kubernetes, Docker, Prometheus et.al infrastructure is now clever enough to make changes to itself based on information supplied by the application. However, if the application does not supply that information, the infrastructure cannot make an informed decision.

Limitations
'''''''''''

Note: This list also constitutes a "Todo"

- This doesn't work yet.

CVRFv1.1 ATOM Feed: https://feeds.littleman.co/security/magento/prometheus.atom _[FIG9]
JSON: https://feeds.littleman.co/security/magento/prometheus.json _[FIG9]

Summary
'''''''

============= ============ ==============
License       Code Style   Locale
------------- ------------ --------------
Apache-2      Zend         en-AU [lang]_
============= ============ ==============

Compatibility
'''''''''''''

Magento  Compatibility

===== ===== ===== ===== ===== =====
 1.9   1.8   1.7   1.6   1.5   1.4
----- ----- ----- ----- ----- -----
  Y     ?     ?     ?     ?     ?
===== ===== ===== ===== ===== =====

Installation
------------

Requirements
''''''''''''

- PHP 
- PHP APCu

Steps
'''''

The recommended way of installing this extension is via Composer. If this is new to you, you can read more at the
following URL:

https://github.com/Cotya/magento-composer-installer

This extension is available via Packagist. You can install it with composer by undertaking the following command:

::

    $ composer require littlemanco/magento-prometheus

Note: To use it, you will need to ensure that the composer autoloader is available to Magento. This package recommends
the following extension to do this:

https://github.com/fontis/composer-autoloader

That's it! You're away.

Usage
-----

This exposes a new endpoint at `/metrics` that exposes the metrics information about the store.

But this information is private!
''''''''''''''''''''''''''''''''

I agree. My suggestion would be block it in .htaccess; I don't think it's a good idea to stick it in admin, though. The endpoint should work almost no matter what.

I have a URL that collides with `/metrics`
''''''''''''''''''''''''''''''''''''''''''

That's no good! Create an issue, and I'll see about making it configurable.

Extending
---------

The extension is a thin wrapper around the PHP library. However, to create a new metric, create a class as follows:

::
    Todo: That

Metrics are singletons, and fetching a model twice will break. Fetch your singleton as follows:

::
    Todo: That

When creating a metric, the following additional PHPDoc tags are useful:

::

    @labels label_a,label_b | The labels that should be updated for this metric

Ongoing Support
---------------

There will be none. Suggest that if this interests you, you fork and maintain it. Being brutally honest, my interest is fleeting, and unless there's professional sponsorship I won't carry this longer then my attention span holds out.

For me, this is a learning experience with Magento and Kubernetes.

Thanks
------

- Matthew Beane (https://twitter.com/aepod)
- Winston Nolan

Contributing
------------

Contributions are always welcome! Nothing is too small, and the best place to start is to open an issue.

References
----------

.. [lang] Lingoes.net,. (2015). Language Code Table. Retrieved 4 June 2015, from http://www.lingoes.net/en/translator/langcode.htm
.. [FIG9] GitHub, (2015). Proposed: security disclosure publication. Retrieved 15 May 2016, from https://github.com/php-fig/fig-standards/blob/master/proposed/security-disclosure-publication.md
