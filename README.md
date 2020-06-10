# SensorML Registry and Repository (SRR)
The primary interface of the SensorML Registry and Repository (SRR) as deployed on https://xdomes.tamucc.edu/srr/. 

## Direct Access of a Record

The SensorML files records can be accessed directly using the following syntax:

https://xdomes.org/srr/sensorML.php?urn={enter the URN of the record on file}

*Example:*

https://xdomes.org/srr/sensorML.php?urn=urn:whoi:mvco:mvco_workhorse_1200

Alternatively, if the direct filename is available (the ':' characters are replaced with '-'), a direct HTTP call (i.e. API-less) can also be used to access the SensorML file.

*Example:*

https://xdomes.org/srr/sensorML/urn-whoi-mvco-mvco_workhorse_1200.xml

## Query the Registry

The SensorML files in the registry can be queries using the following syntax:

https://xdomes.org/srr/sensorML.php?query={enter query term}&attribute={enter attribute to search (e.g. description)}

*Example:*

https://xdomes.org/srr/sensorML.php?query=RD&attribute=description
