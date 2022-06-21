<?php

namespace hachkingtohach1\reallycheat\components\config;

use hachkingtohach1\reallycheat\components\registry\ComponentWithName;

abstract class ConfigPaths implements ComponentWithName{

    public const PREFIX = "reallycheat.prefix";

    public const ALERTS_MESSAGE = "reallycheat.alerts.message";
    public const ALERTS_ENABLE = "reallycheat.alerts.enable";
    public const ALERTS_PERMISSION = "reallycheat.alerts.permission";
    public const ALERTS_ADMIN = "reallycheat.alerts.admin";

    public const BAN_COMMANDS = "reallycheat.ban.commands";
    public const BAN_MESSAGE = "reallycheat.ban.message";
    public const BAN_ENABLE = "reallycheat.ban.enable";
    public const BAN_RANDOMIZE = "reallycheat.ban.randomize";
    public const BAN_RECENT_LOGS_MESSAGE = "reallycheat.ban.recentlogs.message";  

    public const TRANSFER_IP = "reallycheat.transfer.ip";
    public const TRANSFER_USECOMMAND_ENABLE = "reallycheat.transfer.usecommand.enable";
    public const TRANSFER_USECOMMAND_COMMANDS = "reallycheat.transfer.usecommand.commands";
    public const TRANSFER_MESSAGE = "reallycheat.transfer.message";
    public const TRANSFER_RANDOMIZE = "reallycheat.transfer.randomize";
    public const TRANSFER_RECENT_LOGS_MESSAGE = "reallycheat.transfer.recentlogs.message"; 

    public const PERMISSION_BYPASS_ENABLE = "reallycheat.permissions.enable";
    public const PERMISSION_BYPASS_PERMISSION = "reallycheat.permissions.permission";

    public function getComponentName() :string{
		return "ReallyCheat_ConfigPaths";
	}

}