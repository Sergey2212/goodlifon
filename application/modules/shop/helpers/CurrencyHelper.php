<?php
namespace app\modules\shop\helpers;

use app\modules\shop\models\Currency;
use app\modules\shop\models\UserPreferences;

class CurrencyHelper
{
    /**
     * @var Currency $userCurrency
     * @var Currency $mainCurrency
     */
    static protected $userCurrency = null;
    static protected $mainCurrency = null;

    /**
     * @return Currency
     */
    static public function getUserCurrency()
    {
        if (null === static::$userCurrency) {
            static::$userCurrency = static::findCurrencyByIso(UserPreferences::preferences()->userCurrency);
        }

        return static::$userCurrency;
    }

    /**
     * @param Currency $userCurrency
     * @return Currency
     */
    static public function setUserCurrency(Currency $userCurrency)
    {
        return static::$userCurrency = $userCurrency;
    }

    /**
     * @return Currency
     */
    static public function getMainCurrency()
    {
        return null === static::$mainCurrency
            ? static::$mainCurrency = Currency::getMainCurrency()
            : static::$mainCurrency;
    }

    /**
     * @param string $code
     * @param bool|true $useMainCurrency
     * @return Currency
     */
    static public function findCurrencyByIso($code)
    {
        $currency = Currency::find()->where(['iso_code' => $code])->one();
        $currency = null === $currency ? static::getMainCurrency() : $currency;
        return $currency;
    }

    /**
     * @param float|int $input
     * @param Currency $from
     * @param Currency $to
     * @return float|int
     */
    static public function convertCurrencies(Currency $from, Currency $to, $input = 0)
    {
        if (0 === $input) {
            return $input;
        }

        if ($from->id !== $to->id) {
            $main = static::getMainCurrency();
            if ($main->id === $from->id && $main->id !== $to->id) {
                $input = $input / $to->convert_rate * $to->convert_nominal;
            } elseif ($main->id !== $from->id && $main->id === $to->id) {
                $input = $input / $from->convert_nominal * $from->convert_rate;
            } else {
                $input = $input / $from->convert_nominal * $from->convert_rate;
                $input = $input / $to->convert_rate * $to->convert_nominal;
            }
        }

        return $to->formatWithoutFormatString($input);
    }

    /**
     * @param float|int $input
     * @param Currency $from
     * @return float|int
     */
    static public function convertToUserCurrency(Currency $from, $input = 0)
    {
        return static::convertCurrencies($from, static::getUserCurrency(), $input);
    }

    /**
     * @param float|int $input
     * @param Currency $from
     * @return float|int
     */
    static public function convertToMainCurrency(Currency $from, $input = 0)
    {
        return static::convertCurrencies($from, static::getMainCurrency(), $input);
    }

    /**
     * @param float|int $input
     * @param Currency $to
     * @return float|int
     */
    static public function convertFromMainCurrency(Currency $to, $input = 0)
    {
        return static::convertCurrencies(static::getMainCurrency(), $to, $input);
    }

    /**
     * @param Currency $currency
     * @param string|null $locale
     * @return string
     */
    static public function getCurrencySymbol(Currency $currency, $locale = null)
    {
        $locale = null === $locale ? \Yii::$app->language : $locale;

        $result = '';
        try {
            $fake = $locale . '@currency=' . $currency->iso_code;
            $fmt = new \NumberFormatter($fake, \NumberFormatter::CURRENCY);
            $result = $fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
        } catch (\Exception $e) {
            $result = preg_replace('%[\d\s,]%i', '', $currency->format(0));
        }

        return $result;
    }
}
