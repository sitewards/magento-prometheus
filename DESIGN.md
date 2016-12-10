# Design

Currently, thinking about whether we should checkpoint metrics with observers or just query them from existing data on an ad-hoc basis. Ultimately, that will be left up to the providers -- but the initial extension will set the tone. 

I'm  leaning towards the latter, at least for a POC. The reason is 
- I don't want have to clean up data
- Checkpointed data can become out of sync
- It has to be stored in shared storage anyway, which means querying it -- something that, if the queries are constructed correctly, isn't that much more efficient then just querying data ad-hoc.

There is an existing PHP prometheus library that goes the other way, and just checkpoints data. It then stores that in APCu. This provides both an efficient means of determining metrics, and is shared storage available to all PHP processes on a single host. It seems like an elegant solution. 

The library also allows publication to Redis, which is good if more permanent storage (aside from APCu) is required. Lastly, at this stage it appears this extension allows a plugin interface for it's data storage.

## Metrics

### Per-host metrics

Metrics should be collected on a per-host basis. The justification for this is severalfold:

- It appears to be the way Prometheus queries things more generally -- collect just the metrics of each host, and do calculations for summaries by querying this data.
- It means there is no confusion between "service" and "application" level metrics. It's all application level.
- It allows seeing whether one host is "sicker" than others for all metrics.

### Choice of metrics 

At this time, the priority is not to track metrics that can otherwise be tracked by JavaScript based tracking engines (such as Google Analytics)

### Checkpoint metrics versus Query metrics

Where a metric is checkpointed as part of the normal request lifecycle, no additional metric needs to be calculated. However, where a metric is queried (for example, number of {x} processed in {y}), additional metrics documenting both latency and failure rate should be created.[1]

### Name

Each metric is prefixed with `magento_`[2]

### Store specific metrics

Where a metric is store specific, apply the store_code label to it with the store code value.

### Design Notes

The following is the design spec for each metric. As of now, none are implemented.  

| Metric                               | What it means                                                           | Type of metric | Labels       |  
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_cron_execution_timestamp     | The unix timestamp of the last cron execution                           | Counter        |              |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_cron_queue_length            | The number of cron jobs that are due for processing in Magento          | Guadge (0,)    |              |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_indexer_status_ready         | Whether the indexer is "ready", or needs reindexing                     | Gaudge (0,1)   | indexer_code |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_indexer_reindex_total        | A count of the number of times the indexer has been reindexed           | Counter        | indexer_code |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_cache_status_enabled         | Whether the cache is enabled and valid                                  | Guadge (0,1)   | cache_type   |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_cache_flush_total            | A count of the number of cache flushes                                  | Counter        | cache_type   |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_orders_completed_total       | A count of the number of completed orders                               | Counter        | store_code   |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_orders_shipped_total         | A count of the number of shipped orders                                 | Counter        | store_code   |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_orders_returns_total         | A count of the number of returned orders                                | Counter        | store_code   |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_uncaught_exceptions_total    | A count of the number of uncaught exceptions                            | Counter        |              | 
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_gift_card_usage_total        | A count of the usage of gift cards                                      | Counter        |              |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_customer_login_total         | A count of the number of times a Magento user has logged in             | Counter        | store_code   |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|
| magento_promotion_code_usage_total   | A count of the number of times promo codes have been used               | Counter        | code         |
|--------------------------------------|-------------------------------------------------------------------------|----------------|--------------|

## References

[1] - https://www.prometheus.io/docs/practices/instrumentation
[2] - https://www.prometheus.io/docs/practices/naming
