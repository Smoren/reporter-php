<?php


namespace Smoren\Reporter\Components;


use Smoren\Reporter\Structs\ReportLevel;
use Smoren\Reporter\Structs\ReportType;

class ReportCollector
{
    /**
     * @var array[][]
     */
    protected $storage = [
        ReportLevel::ERROR => [],
        ReportLevel::WARNING => [],
        ReportLevel::NOTICE => [],
    ];

    /**
     * @param string $type
     * @param string $message
     * @param array $extra
     * @return $this
     */
    public function addNotice(string $type, string $message, array $extra = []): self
    {
        return $this->add(ReportLevel::NOTICE, $type, $message, $extra);
    }

    /**
     * @param string $type
     * @param string $message
     * @param array $extra
     * @return $this
     */
    public function addWarning(string $type, string $message, array $extra = []): self
    {
        return $this->add(ReportLevel::WARNING, $type, $message, $extra);
    }

    /**
     * @param string $type
     * @param string $message
     * @param array $extra
     * @return $this
     */
    public function addError(string $type, string $message, array $extra = []): self
    {
        return $this->add(ReportLevel::ERROR, $type, $message, $extra);
    }

    /**
     * @return bool
     */
    public function hasNotices(): bool
    {
        return count($this->storage[ReportLevel::NOTICE]);
    }

    /**
     * @return bool
     */
    public function hasWarnings(): bool
    {
        return count($this->storage[ReportLevel::WARNING]);
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->storage[ReportLevel::ERROR]);
    }

    /**
     * @return bool
     */
    public function hasProblems(): bool
    {
        return $this->hasWarnings() || $this->hasErrors();
    }

    /**
     * @param string|null $reportTypeClass
     * @return array
     */
    public function getSummary(?string $reportTypeClass = null): array
    {
        $result = [];

        foreach($this->storage as $level => $levelTypes) {
            if(!count($levelTypes)) continue;

            $item = [
                'alias' => $level,
                'name' => ReportLevel::getTitle($level),
                'data' => [],
            ];

            foreach($levelTypes as $type => $data) {
                if(
                    class_exists($reportTypeClass)
                    && method_exists($reportTypeClass, 'getTitle')
                ) {
                    $name = $reportTypeClass::getTitle($type);
                } else {
                    $name = null;
                }

                $dataCount = count($data);
                $item['data'][] = [
                    'alias' => $type,
                    'name' => $name,
                    'count' => $dataCount,
                ];
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->storage;
    }

    /**
     * @return int
     */
    public function getMaxLevel(): int
    {
        if(count($this->storage[ReportLevel::ERROR])) {
            return 3;
        }
        if(count($this->storage[ReportLevel::WARNING])) {
            return 2;
        }
        if(count($this->storage[ReportLevel::NOTICE])) {
            return 1;
        }
        return 0;
    }

    /**
     * @param string $level
     * @param string $type
     * @param string $message
     * @param array $extra
     * @return $this
     */
    protected function add(string $level, string $type, string $message, array $extra = []): self
    {
        if(!isset($this->storage[$level][$type])) {
            $this->storage[$level][$type] = [];
        }

        $this->storage[$level][$type][] = [
            'message' => $message,
            'extra' => $extra,
        ];

        return $this;
    }
}
