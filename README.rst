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

You can add custom metrics to Prometheus from your own code. To do so, fire events using the Magento event API.
Specify a suitable event name and, if necessary, add an additional data like an identification string.

::

    Mage::dispatchEvent('namespace_extension_custom_event_name', ['name' => $this->sIdentificationString]);

Create an extension in your Magento project that will take care of the metrics being send to Prometheus.
Define an observer listening to all the events you want to track. You can listen to native Magento events or define
your own custom events:

::

    // config.xml
    <frontend>
        <events>
            <namespace_extension_event_name>
                <observers>
                    <namespace_extension_event_name>
                        <class>Namespace_Extension_Model_Observer</class>
                        <method>pushMetric</method>
                    </namespace_extension_event_name>
                </observers>
            </sitewards_importer_step_process>
        </events>
    </frontend>

In the observer class create a push-metric call utilizing the handy metric factory.

::

    public function checkpointCache(Varien_Event_Observer $oEvent) {
       Mage::getModel('littlemanco_prometheus/metricFactory')
            ->getCounter(
                '<metric_name>',
                [
                    'metric_help' => '<Description of the metric>',
                    'label_titles' => ['<label>']
                ]
            )
            ->increment(1, [$oEvent->getType()]);
    }

In the example above, replace ```<metric_name>``` with a sensible name like ```'cache_flush_total'``` that describes
what is counted. Replace ```<Description of the metric>``` with a description that will help to understand the
metric (e.g. 'The total number of times the cache has been flushed'). Change ```<label>``` to contain a sensible
label for sorting in the prometheus data visualization.

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
