// Replace with your fleet group UUID
key FLEET_GROUP = "xxxxx-xxxxxxx-xxxxxxx-xxxxxx";  
string SERVER_URL = "https://yourserver.com/fleetlog.php"; // replace with your endpoint
integer HUD_CHANNEL = -9000; // private channel for text box input
// Define channels
integer JOB_CHANNEL = -9001;       // channel for job input
integer DEST_CHANNEL = -9002;      // channel for destination input

string driverJob = "";
string driverDestination = "";

default
{
    state_entry()
    {
        // Register listeners for both channels
        llListen(JOB_CHANNEL, "", llGetOwner(), "");
        llListen(DEST_CHANNEL, "", llGetOwner(), "");
    }

    attach(key id)
    {
        if (id != NULL_KEY)
        {
            // Re-register listeners when HUD is attached
            llListen(JOB_CHANNEL, "", llGetOwner(), "");
            llListen(DEST_CHANNEL, "", llGetOwner(), "");
        }
    }

    touch_start(integer total_number)
    {
        key owner = llGetOwner();

        // Group restriction check
        if (!llSameGroup(owner))
        {
            llOwnerSay("Wrong group. Please activate the fleet group.");
            return;
        }

        // First prompt: ask for job
        llTextBox(owner, "Enter job type (e.g. 'Container Delivery')", JOB_CHANNEL);
    }

    listen(integer channel, string name, key id, string message)
    {
        if (id != llGetOwner()) return;

        if (channel == JOB_CHANNEL)
        {
            driverJob = llStringTrim(message, STRING_TRIM);
            llOwnerSay("Job recorded: " + driverJob);

            // Prompt for destination next
            llTextBox(llGetOwner(), "Enter destination (e.g. 'Port Alpha')", DEST_CHANNEL);
        }
        else if (channel == DEST_CHANNEL)
        {
            driverDestination = llStringTrim(message, STRING_TRIM);
            llOwnerSay("Destination recorded: " + driverDestination);

            // Now send both job and destination to server
            key owner = llGetOwner();
            string driver = llKey2Name(owner);
            vector pos = llGetPos();
        
            string region = llGetRegionName(); // ✅ region name

            string payload = "driver=" + llEscapeURL(driver)
                           + "&job=" + llEscapeURL(driverJob)
                           + "&destination=" + llEscapeURL(driverDestination)
                           + "&location=" + llEscapeURL((string)pos)
                           + "&region=" + llEscapeURL(region);

            llHTTPRequest(SERVER_URL,
                [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded"],
                payload);

            llOwnerSay("Job reported: " + driverJob + " → " + driverDestination
                       + " @ " + region + " " + (string)pos);
        }
    }
}
