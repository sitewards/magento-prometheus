Project Outline
----------------

Project Goals
'''''''''''''

1. Expose certain limited metrics about a store for use in diagnosing an issue
2. Provide a model to extend the metrics exposed to write arbitrary additional metrics to the endpoint 

This project is intended to make it easier to introspect one, or several running Magento stores.

Scope
"""""

There are two sets of metrics that we're interested in: 

  - Service level metrics
  - Instance level metrics

Instance level metrics are things that matter about exactly this machine (for example, memory usage). Service level metrics are things that matter about Magento more generally, like number of orders or sessions.

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
-------------

Todo: Fill this out

Add the satis repository

    .. code::
    {
       "repositories": [
           {
               "type": "composer",
               "url": "https://example-com"
           }
       ]
    }

Do a thing

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

Todo: Write this out. Loosely, the goal is to have this similar to Magento cron - declare some configuration that things can hook into. 

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
-----------

.. [lang] Lingoes.net,. (2015). Language Code Table. Retrieved 4 June 2015, from http://www.lingoes.net/en/translator/langcode.htm
.. [FIG9] GitHub, (2015). Proposed: security disclosure publication. Retrieved 15 May 2016, from https://github.com/php-fig/fig-standards/blob/master/proposed/security-disclosure-publication.md
