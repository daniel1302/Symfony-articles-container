<?php
namespace AppBundle\Utils;


class OSDetector
{
    const WIN_311 = 'Windows 3.11';
    const WIN_95 = 'Windows 95';
    const WIN_98 = 'Windows 88';
    const WIN_2000 = 'Windows 2000';
    const WIN_XP = 'Windows XP';
    const WIN_SERVER_2003 = 'Windows Server 2003';
    const WIN_VISTA = 'Windows Vista';
    const WIN_7 = 'Windows 7';
    const WIN_8 = 'Windows 8';
    const WIN_10 = 'Windows 10';
    const WIN_NT40 = 'Windows NT 4.0';
    const WIN_ME = 'Windows ME';
    const BSD = 'Open BSD';
    const LINUX = 'Linux';
    const MAC_OX = 'Apple Mac OS';
    const SUN_OS = 'Sun OS';
    const QNX = 'QNX';
    const BE_OS = 'Be OS';
    const OS2 = 'OS/2';
    const OTHER = '-';

    const TYPES = [
        self::WIN_311,
        self::WIN_95,
        self::WIN_98,
        self::WIN_2000,
        self::WIN_XP,
        self::WIN_SERVER_2003,
        self::WIN_VISTA,
        self::WIN_7,
        self::WIN_8,
        self::WIN_10,
        self::WIN_NT40,
        self::WIN_ME,
        self::BSD,
        self::LINUX,
        self::MAC_OX,
        self::SUN_OS,
        self::QNX,
        self::BSD,
        self::OS2,
        self::OTHER
    ];


    /**
     * Windows XP => (Windows NT 5.1)|(Windows XP),
     * Windows Server 2003 => (Windows NT 5.2),
     * Windows Vista => (Windows NT 6.0),
     * Windows 7 => (Windows NT 6.1),
     * Windows 8 => (Windows NT 6.2),
     * Windows 10 => (Windows NT 10.0),
     * Windows NT 4.0 => (Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT),
     * Windows ME => Windows ME,
     * Open BSD => OpenBSD,
     * Sun OS => SunOS,
     * Linux => (Linux)|(X11),
     * Mac OS => (Mac_PowerPC)|(Macintosh),
     * QNX => QNX,
     * BeOS => BeOS,
     * OS/2 => OS/2
     *
     * @param string $userAgent
     * @return string
     */
    public static function fromUserAgent(string $userAgent): string
    {
        $userAgentL = strtolower($userAgent);
        if (strpos($userAgentL, 'win16') !== false) {
            return self::WIN_311;
        }

        if (strpos($userAgentL, 'win95') !== false ||
            stripos($userAgentL, 'windows_95') !== false ||
            preg_match('/Windows\040+95/i', $userAgentL)
        ) {
            return self::WIN_95;
        }

        if (stripos($userAgentL, 'win98') !== false ||
            preg_match('/Windows\040+98/i', $userAgentL)
        ) {
            return self::WIN_98;
        }

        if (preg_match('/Windows\040+NT\040+5\.0/i', $userAgentL) ||
            preg_match('/Windows\040+2000/i', $userAgentL)
        ) {
            return self::WIN_2000;
        }

        if (preg_match('/Windows\040+NT\040+5\.1/i', $userAgentL) ||
            preg_match('/Windows\040+XP/i', $userAgentL)
        ) {
            return self::WIN_XP;
        }

        if (preg_match('/Windows\040+NT\040+5\.2/i', $userAgentL)) {
            return self::WIN_SERVER_2003;
        }

        if (preg_match('/Windows\040+NT\040+6\.0/i', $userAgentL)) {
            return self::WIN_VISTA;
        }

        if (preg_match('/Windows\040+NT\040+6\.1/i', $userAgentL)) {
            return self::WIN_7;
        }

        if (preg_match('/Windows\040+NT\040+6\.2/i', $userAgentL)) {
            return self::WIN_7;
        }

        if (preg_match('/Windows\040+NT\040+10/i', $userAgentL)) {
            return self::WIN_10;
        }

        if (preg_match('/Windows\040+ME/i', $userAgentL)) {
            return self::WIN_ME;
        }

        if (preg_match('/Sun\040+OS/i', $userAgentL)) {
            return self::SUN_OS;
        }

        if (stripos($userAgentL, 'bsd') !== false) {
            return self::WIN_ME;
        }

        if (stripos($userAgentL, 'winnt4.0') !== false ||
            stripos($userAgentL, 'winnt') !== false||
            preg_match('/Windows\040+NT/i', $userAgentL) ||
            preg_match('/Windows\040+NT\040+4\.0/i', $userAgentL)) {
            return self::WIN_NT40;
        }

        if (strpos($userAgentL, 'x11') !== false ||
            stripos($userAgentL, 'linux') !== false) {
            return self::LINUX;
        }

        if (strpos($userAgentL, 'mac_powerpx') !== false ||
            stripos($userAgentL, 'macintosh') !== false) {
            return self::MAC_OX;
        }

        if (strpos($userAgentL, 'qnx') !== false) {
            return self::QNX;
        }

        if (strpos($userAgentL, 'beos') !== false) {
            return self::BE_OS;
        }

        if (strpos($userAgentL, 'os/2') !== false) {
            return self::OS2;
        }

        return self::OTHER;
    }
}