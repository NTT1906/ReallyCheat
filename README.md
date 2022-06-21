<a align="center"><img src="https://github.com/hachkingtohach1/ReallyCheat/blob/main/ReallyCheat.png"></img></a>
<img src="https://github.com/hachkingtohach1/ReallyCheat/blob/main/ReallyCheat.png" alt="ReallyCheat" height="100" width="200" />
# ReallyCheat (FREE)
- This is AntiCheat for Pocketmine-PMMP4
- If I detect an error, you can submit a Issues on this project, I will still develop this project in the near future.

# Feature

When you turn on "Ban" in the Config section they will allow the modules that I have listed to tag BAN below to be issued.

- KillAura
- Reach
- Fly
- JetPack
- AirJump
- Glide
- Nuker (If you're using a special method to get through it, use the plugin's API method to prevent false detection.) (BAN)
- FastBreak (If you're using a special method to get through it, use the plugin's API method to prevent false detection.) (BAN)
- FillBlock
- 2 Badpackets
- AutoArmor (WIP)

# ReallyCheat (Premium)
- This is a version that is still in development we will update in detail here when it is completed.

# Config Example
```---
reallycheat:
    prefix: "§cRCheat"
    alerts: 
        message: "{prefix} §8> §f{player} §7failed §f{module} §7VL §2{violation}"
        enable: true
        admin: false #This will cause the in-game cheat detector to send it to the person with the permissions below 
        permission: "reallycheat.notify"
    ban:
        commands:
            - "ban {player} You are hacking!"
        message: "{prefix} §8> §f{player} §chas been removed from server for hacking or abuse."
        enable: true
        randomize: false
        recentlogs:
            message: "{time}/{prefix} > {player} failed {module} VL {violation} | penalty: BAN"
    transfer:             
        ip: "play.example.net:19132" #If "usecommand" enabled, it will not work  
        usecommand:
            enable: false
            commands:
                - "transfer {player} play.example.net"
        message: "{prefix} §8> §f{player} §chas been kicked from server for hacking or abuse."
        randomize: false
        recentlogs:
            message: "{time}/{prefix} > {player} failed {module} VL {violation} | penalty: TRANSFER"       
    permissions:
        bypass:
            enable: false
            permission: "reallycheat.bypass"
...
```
