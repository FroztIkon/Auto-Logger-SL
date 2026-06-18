// Replace with your fleet group UUID
key FLEET_GROUP = "xxxxx-xxxxxxx-xxxxxxx-xxxxxx";  
string SERVER_URL = "https://yourserver.com/fleetlog.php"; // replace with your endpoint

integer GTFO_CHANNEL = -9600; // GTFO HUD speaks here
default
{
    state_entry()
    {
        // Listen for GTFO freight messages
        llListen(GTFO_CHANNEL, "", NULL_KEY, "");
    }

    listen(integer channel, string name, key id, string message)
    {
        if (channel == GTFO_CHANNEL)
        {
            key owner = llGetOwner();
            string ownerName = llKey2Name(owner);

            // Get HUD’s group UUID
            list details = llGetObjectDetails(llGetKey(), [OBJECT_GROUP]);
            key hudGroup = llList2Key(details, 0);

            // Check HUD is set to Fleet group
            if (hudGroup != FLEET_GROUP)
            {
                llOwnerSay("This HUD is not set to the Fleet group.");
                return;
            }

            // Check driver’s active group matches HUD’s group
            if (!llSameGroup(owner))
            {
                llOwnerSay("Access denied. Please activate the Fleet group.");
                return;
            }

            // Parse GTFO message
            list parts = llParseString2List(message, [" "], []);
            if (llGetListLength(parts) < 5) return; // sanity check

            string driver = llList2String(parts, 0) + " " + llList2String(parts, 1);

            // ✅ Only log if the message driver matches this HUD’s owner
            if (driver != ownerName) return;

            string action;
            string cargoCount;
            string cargoType;

            if (llList2String(parts, 2) == "picked" && llList2String(parts, 3) == "up")
            {
                action = "picked up";
                cargoCount = llList2String(parts, 4);
                cargoType = llDumpList2String(llList2List(parts, 5, -1), " ");
            }
            else if (llList2String(parts, 2) == "unloaded")
            {
                action = "unloaded";
                cargoCount = llList2String(parts, 3);
                cargoType = llDumpList2String(llList2List(parts, 4, -1), " ");
            }
            else
            {
                action = llList2String(parts, 2); // fallback
                cargoCount = "";
                cargoType = llDumpList2String(llList2List(parts, 3, -1), " ");
            }

            vector pos = llGetPos();
            string region = llGetRegionName();

            // Build SLURL
            string slurl = "http://maps.secondlife.com/secondlife/"
                         + llEscapeURL(region) + "/"
                         + (string)((integer)pos.x) + "/"
                         + (string)((integer)pos.y) + "/"
                         + (string)((integer)pos.z);

            // Build payload
            string payload = "driver=" + llEscapeURL(driver)
                           + "&action=" + llEscapeURL(action)
                           + "&amount=" + llEscapeURL(cargoCount)
                           + "&cargo=" + llEscapeURL(cargoType)
                           + "&slurl=" + llEscapeURL(slurl);

            // Send to server
            llHTTPRequest(SERVER_URL,
                [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
                payload);

            // Feedback in-world
            llOwnerSay("Logged: " + driver + " " + action + " " + cargoCount + " " + cargoType
                       + " @ " + slurl);
        }
    }
}
