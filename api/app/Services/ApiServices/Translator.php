<?php
declare(strict_types=1);

namespace App\Services\ApiServices;

use App\Services\ApiServices\Interfaces\TranslatorInterface;
use Illuminate\Contracts\Translation\Translator as IlluminateTranslator;

class Translator implements TranslatorInterface
{
    /**
     * Contracted translator instance
     *
     * @var \Illuminate\Contracts\Translation\Translator
     */
    private $translator;

    /**
     * Create new translation instance
     *
     * @param \Illuminate\Contracts\Translation\Translator $contract Contracted translator instance
     */
    public function __construct(IlluminateTranslator $contract)
    {
        $this->translator = $contract;
    }

    /**
     * Get a value from the language file
     *
     * @param string $key The key to fetch the message for
     * @param mixed[]|null $replace Attributes to replace within the message
     * @param string|null $locale The locale to fetch the key from
     *
     * @return string|string[]|null
     */
    public function get(string $key, ?array $replace = null, ?string $locale = null)
    {
        return $this->translator->trans($key, $replace ?? [], $locale);
    }

    /**
     * Get a value from the language file and ensure a string is always returned
     *
     * @param string $key The key to fetch the message for
     * @param mixed[]|null $replace Attributes to replace within the message
     * @param string|null $locale The locale to fetch the key from
     *
     * @return string|null
     */
    public function trans(string $key, ?array $replace = null, ?string $locale = null): ?string
    {
        $translated = $this->get($key, $replace ?? [], $locale);

        return \is_array($translated) ? \implode(', ', $translated) : $translated;
    }
}
