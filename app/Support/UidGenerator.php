<?php

namespace App\Support;

use InvalidArgumentException;
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

        if (method_exists($this, $uidType)) {
            return call_user_func_array(
                [$this, $uidType],
                $this->options['parameters'] ?? []
            );
        }

        throw new InvalidArgumentException("Method {$uidType} does not exist");
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options = []): void
    {
        $this->options = $options;
    }

    /**
     * Generate a unique && unambiguous order confirmation number.
     *
     * @return string
     */
    public function orderConfirmationNumber(): string
    {
        return substr(str_shuffle(str_repeat(
            $this->characterPool,
            self::CHARACTER_LENGTH
        )), 0, self::CHARACTER_LENGTH);
    }

    /**
     * A human friendly, numbers only UUID, which has the nano seconds precision.
     *
     * @param array $options
     *
     * @return string
     */
    public function humanUuid(array $options = []): string
    {
        $useDashes = $options['useDashes'] ?? false;

        $dash = $useDashes ? '-' : '';

        $uuid = date('YmdHis') . substr(explode(' ', microtime())[0], 2, 8) . rand(100000000000, 999999999999);

        return substr($uuid, 0, 8) . $dash . substr($uuid, 8, 4) . $dash . substr($uuid, 12, 4) . $dash . substr($uuid, 16, 4) . $dash . substr($uuid, 20, 12);
    }
}
