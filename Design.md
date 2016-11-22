Design
''''''

Currently, thinking about whether we should checkpoint metrics with observers or just query them from existing data on an ad-hoc basis. Ultimately, that will be left up to the providers -- but the initial extension will set the tone. 

I'm  leaning towards the latter, at least for a POC. The reason is 
- I don't want have to clean up data
- Checkpointed data can become out of sync
- It has to be stored in shared storage anyway, which means querying it -- something that, if the queries are constructed correctly, isn't that much more efficient then just querying data ad-hoc.
