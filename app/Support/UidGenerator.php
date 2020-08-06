<?php

namespace App\Support;

use App\Contracts\Support\Generator;

class UidGenerator implements Generator
{
    /**
     * String of acceptable characters.
     *
     * @var string
     */
    protected $characterPool = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Default UID character length.
     */
    public const CHARACTER_LENGTH = 24;

    /**
     * Generator options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $uidType = $this->options['type'];

        return $this->$uidType($this->options['parameters']);
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options = []): void
    {
        $this->options = $options;
    }

    /**
     * Generate a unique and unambiguous order confirmation number.
     *
     * @return string
     */
    public function orderConfirmationNumber(): string
    {
        return substr(str_shuffle(str_repeat($this->characterPool, self::CHARACTER_LENGTH)), 0, self::CHARACTER_LENGTH);
    }

    /**
     * A human friendly, numbers only UUID, which has the nano seconds precission
     * 32 digits - YYYYMMDD-HHMM-SSMM-MMMMRRRRRRRRRRRR.
     *
     * @return string
     */
    public function humanUuid($options = [])
    {
        $useDashes = $options['useDashes'] ?? false;

        $dash = $useDashes ? '-' : '';

        $uuid = date('YmdHis') . substr(explode(' ', microtime())[0], 2, 8) . rand(100000000000, 999999999999);

        return substr($uuid, 0, 8) . $dash . substr($uuid, 8, 4) . $dash . substr($uuid, 12, 4) . $dash . substr($uuid, 16, 4) . $dash . substr($uuid, 20, 12);
    }

    /**
     * Time based unique id with nano seconds precission. No dashes.
     * 23 digits - YYYYMMDD-HHMMSS-MMMMMM-NNN.
     *
     * @return string
     */
    public function nanoUid($options = [])
    {
        $useDashes = $options['useDashes'] ?? false;

        $dash = $useDashes ? '-' : '';

        $microsecs = substr(explode(' ', microtime())[0], 2, 6);

        $nanosecs = substr(exec('date +%s%N'), -3);

        return date('YmdHis') . $dash . $microsecs . $dash . $nanosecs;
    }

    /**
     * Time based unique id with micro seconds precission. No dashes.
     * 20 digits - YYYYMMDD-HHMMSS-MMMMMM.
     *
     * @return string
     */
    public function microUid($options = [])
    {
        $useDashes = $options['useDashes'] ?? false;

        $dash = $useDashes ? '-' : '';

        return date('YmdHis') . substr(explode(' ', microtime())[0], 2, 6);
    }

    /**
     * Time based unique id with seconds precission. No dashes.
     * 14 digits - YYYYMMDD-HHMMSS.
     *
     * @return string
     */
    public function secUid()
    {
        $milliseconds = round(microtime(true) * 1000);

        return date('YmdHis');
    }

    public function timestampUid()
    {
        return time();
    }

    public function timestampUidWithRandomPostFix($postfix_length = 4)
    {
        /* Human Readable Only */
        $chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        shuffle($chars);

        shuffle($chars);

        $postfix = implode('', array_splice($chars, 0, $postfix_length));

        return self::timestampUid() . $postfix;
    }

    public function isHumanUid($string)
    {
        $string = str_replace('-', '', $string);

        if (is_numeric($string) == true and strlen($string) == 32) {
            return true;
        }

        return false;
    }

    public function isNanoUid($string)
    {
        $string = str_replace('-', '', $string);

        if (is_numeric($string) == true and strlen($string) == 23) {
            return true;
        }

        return false;
    }

    public function isMicroUid($string)
    {
        $string = str_replace('-', '', $string);

        if (is_numeric($string) == true and strlen($string) == 20) {
            return true;
        }

        return false;
    }

    public function isSecUid($string)
    {
        $string = str_replace('-', '', $string);

        if (is_numeric($string) == true and strlen($string) == 14) {
            return true;
        }

        return false;
    }
}
