# Auto-Logger-SL
This is meant as a GTFO logger that reports to a endpoint server. Requires drivers to input Cargo then Destination. The LSL auto populates Timestamp, user legacy name, region, and coordinates.

Currently known channels
-9600 : Shows Pick up or Delivery message in the format: legacy name picks up # of cargo or legacy name unloaded # of cargo

Where legacy name is the login name ie user resident or first last
Where # indicated the number of cargo, ie 4 or 10 or 15 or 22, whatever the job is
Where cargo is the name of the cargo ie feel boss or Class-A Freight or Fuel Cells (He-3) etc

GTFO communication channel to HUB loaders is -4836107
