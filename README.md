# Auto-Logger-SL
This is meant as a GTFO logger that reports to a endpoint server. Drivers used to have to input the Destination and the Cargo. Now we're listening for GTFO hud announcements and using them as a trigger to send the data. It outputs into a table:  
Timestamp	Driver	Action	Amount	Cargo	Current Location. Current Location is a SLURL to go to that point.  
The Fetch_hub.php is set to scan the GTFO website's Hubs page. It will replace the data it saves to a file called hub_data.json. The index page has be refactored to show which Hub has been picked up/dropped off instead of a SLURL, since a SLURL doesn't identify the actual HUB. Also further refinement was needed to ensure that it was looking at the region, instead of just coordinates. Duplicates could happen if tracking by coordinates. My suggestion is to create a cronjob that will parse fetch_hubs.php once a week. Any day but Sunday, since that is the GTFO maintenance and update day.  

  Example of Coordinate doublings
  ```
  https://maps.secondlife.com/secondlife/Brooks/127/138/30
  ```
 Would show up and 
 ```
https://maps.secondlife.com/secondlife/Brooks/128/18/300
```
 Would show up as well, even though it is the same region and same hub, again example only of the doubling by coordinate. Resolution was to read the slurl and capture the Region, check the downloaded hub_data.json file, compare, and output the found Hub name.  
 
Currently known channels  
-9600 : Shows Pick up or Delivery message in the format: legacy name picks up # of cargo or legacy name unloaded # of cargo
  
Where legacy name is the login name ie user resident or first last  
Where # indicated the number of cargo, ie 4 or 10 or 15 or 22, whatever the job is  
Where cargo is the name of the cargo ie feel boss or Class-A Freight or Fuel Cells (He-3) etc  
  
GTFO communication channel to HUB loaders is -4836107  
  
Dropping the Repeater script into the AT Gas Pump and AT Oil Refinery Pump with the known GFS channel 993029418 allowed me to see the following examples  
```
[22:17] AT Oil Refinery Pump
GFSL|HERE|<34.07763, 41.05857, 118.34830>#$<0.00000, 0.70711, 0.00000, 0.70711>#$REGULAR#$3478.273000
Refueled: 226.216200 Liters
```
and then  
```
[22:18] 2.AT GasPump US: GFSL|FILL|104.580100|REGULAR
GFSL|FIND
```
and  
```
[22:19] 2.AT GasPump US: GFSL|FILL|111.220100|DIESEL
```
Please note that the Repeater had to be used because the GFS channel is restricted to linked prims via link_message, llRegionSayTo(pumpUUID,993029418,"GFS1|CANCEL"); and llMessageLinked. So there really isn't anything visible on a positive or negative channel to intercept and read.

