<?php
/*
* File: LiveMailboxTestCase.php
* Category: -
* Author: M.Goldenbaum
* Created: 04.03.23 03:43
* Updated: -
*
* Description:
*  -
*/

namespace Tests;

use PHPUnit\Framework\TestCase;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Exceptions\MaskNotFoundException;

/**
 * Class LiveMailboxTestCase
 *
 * @package Tests
 */
abstract class LiveMailboxTestCase extends TestCase {
    const SPECIAL_CHARS = 'A_\\|!"£$%&()=?àèìòùÀÈÌÒÙ<>-@#[]_ß_б_π_€_✔_你_يد_Z_';

    /**
     * Client manager
     * @var ClientManager $manager
     */
    protected static ClientManager $manager;

    /**
     * Get the client manager
     *
     * @return ClientManager
     */
    final protected function getManager(): ClientManager {
        if (!isset(self::$manager)) {
            self::$manager = new ClientManager([
                                                   'accounts' => [
                                                       'default' => [
                                                           'host'          => $_ENV["LIVE_MAILBOX_HOST"] ?? "localhost",
                                                           'port'          => $_ENV["LIVE_MAILBOX_PORT"] ?? 143,
                                                           'protocol'      => 'imap', //might also use imap, [pop3 or nntp (untested)]
                                                           'encryption'    => $_ENV["LIVE_MAILBOX_ENCRYPTION"] ?? false, // Supported: false, 'ssl', 'tls'
                                                           'validate_cert' => $_ENV["LIVE_MAILBOX_VALIDATE_CERT"] ?? false,
                                                           'username'      => $_ENV["LIVE_MAILBOX_USERNAME"] ?? "root@example.com",
                                                           'password'      => $_ENV["LIVE_MAILBOX_PASSWORD"] ?? "foobar",
                                                       ],
                                                   ],
                                               ]);
        }
        return self::$manager;
    }

    /**
     * Get the client
     *
     * @return Client
     * @throws MaskNotFoundException
     */
    final protected function getClient(): Client {
        return $this->getManager()->account('default');
    }
}