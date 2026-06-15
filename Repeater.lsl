default
{
    state_entry()
    {
        // Start listening on channel 993029418 for GFS
        llListen(993029418, "", NULL_KEY, "");
    }

    listen(integer channel, string name, key id, string message)
    {
        // Relay the message to channel 0 (public chat)
        llSay(0, message);
    }
}
