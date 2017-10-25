# M1 bot-constructor

[![Build Status](https://travis-ci.org/RushCode/m1-bot.svg?branch=master)](https://travis-ci.org/RushCode/m1-bot) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/RushCode/m1-bot/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/RushCode/m1-bot/?branch=master) [![Maintainability](https://api.codeclimate.com/v1/badges/ec6c7f7caaa758f3164d/maintainability)](https://codeclimate.com/github/RushCode/m1-bot/maintainability)

# Install Gearman server

```
apt-get install gearman software-properties-common
add-apt-repository ppa:gearman-developers/ppa
add-apt-repository ppa:ondrej/pkg-gearman
apt-get update
apt-get install php-gearman
```

# Install Application

```
composer require leocata/m1-bot
```

# Usage

### Create bot

ExampleBot.php

```
<?php

use leocata\m1Bot\Bot\BaseBot;

class ExampleBot extends BaseBot
{
    public $pass = 'password';
    public $username = 'username';

    public function contactRequested(\GearmanJob $job)
    {
        $message = json_decode($job->workload());
        $this->getApiWrapper()->contactAccept($message->userid, '', 1);
        $job->sendComplete(true);
    }

    public function message(\GearmanJob $job)
    {
        $this->getApiWrapper()->messageDelivered($message->sessionid, $message->id);
        $this->getApiWrapper()->messageTyped($message->sessionid, $message->orig);
        $job->sendComplete(true);
    }
}
```

### Start Example Bot

#### Start WebSocket client

```
vendor/bin/mbot-cli websocket --bot ExampleBot
```

#### Start Gearman workers

```
vendor/bin/mbot-cli gearman --bot ExampleBot
```

### Use supervisor

Add file /etc/supervisor/conf.d/websocket_client_exampleBot.conf

```
[program:websocket_client_exampleBot]
command                 = vendor/bin/mbot-cli websocket --bot ExampleBot
process_name            = websocket_client
numprocs                = 1
autostart               = true
autorestart             = true
user                    = mbot
stdout_logfile          = /var/logs/exampleBot-websocket-info.log
stdout_logfile_maxbytes = 1MB
stderr_logfile          = /var/logs/exampleBot-websocket-error.log
```

Add file /etc/supervisor/conf.d/gearman_worker_exampleBot.conf

```
[program:gearman_worker_exampleBot]
command                 = vendor/bin/mbot-cli gearman --bot ExampleBot
process_name            = websocket_client
numprocs                = 1
autostart               = true
autorestart             = true
user                    = mbot
stdout_logfile          = /var/logs/exampleBot-gearman-info.log
stdout_logfile_maxbytes = 1MB
stderr_logfile          = /var/logs/exampleBot-gearman-error.log
```