<?php

namespace Smoren\Reporter\Tests\Unit;


use Smoren\Reporter\Components\ReportCollector;
use Smoren\Reporter\Tests\Unit\Structs\ReportType;

class ReporterTest extends \Codeception\Test\Unit
{
    public function testMain()
    {
        $reportCollector = new ReportCollector();
        
        $this->assertEquals(0, $reportCollector->getMaxLevel());
        $this->assertFalse($reportCollector->hasProblems());
        $this->assertFalse($reportCollector->hasErrors());
        $this->assertFalse($reportCollector->hasWarnings());
        $this->assertFalse($reportCollector->hasNotices());

        $reportCollector->addNotice(ReportType::NOTICE_TEST, 'notice test 1', ['notice_test' => 1]);
        $this->assertEquals(1, $reportCollector->getMaxLevel());
        $this->assertFalse($reportCollector->hasProblems());
        $this->assertFalse($reportCollector->hasErrors());
        $this->assertFalse($reportCollector->hasWarnings());
        $this->assertTrue($reportCollector->hasNotices());

        $reportCollector->addWarning(ReportType::WARNING_TEST, 'warning test 1', ['warning_test' => 1]);
        $this->assertEquals(2, $reportCollector->getMaxLevel());
        $this->assertTrue($reportCollector->hasProblems());
        $this->assertFalse($reportCollector->hasErrors());
        $this->assertTrue($reportCollector->hasWarnings());
        $this->assertTrue($reportCollector->hasNotices());

        $reportCollector->addError(ReportType::ERROR_TEST, 'error test 1', ['error_test' => 1]);
        $reportCollector->addError(ReportType::ERROR_TEST, 'error test 2', ['error_test' => 2]);
        $reportCollector->addError(ReportType::ERROR_UNKNOWN, 'error unknown', ['error_unknown' => 1]);
        $this->assertEquals(3, $reportCollector->getMaxLevel());
        $this->assertTrue($reportCollector->hasProblems());
        $this->assertTrue($reportCollector->hasErrors());
        $this->assertTrue($reportCollector->hasWarnings());
        $this->assertTrue($reportCollector->hasNotices());

        $summary = $reportCollector->getSummary(ReportType::class);
        $this->assertEquals([
            [
                'alias' => 'error',
                'name' => 'Errors',
                'data' => [
                    [
                        'alias' => 'error_test',
                        'name' => 'Test error',
                        'count' => 2
                    ],
                    [
                        'alias' => 'error_unknown',
                        'name' => 'Unknown error',
                        'count' => 1
                    ],
                ],
            ],
            [
                'alias' => 'warning',
                'name' => 'Warnings',
                'data' => [
                    [
                        'alias' => 'warning_test',
                        'name' => 'Test warning',
                        'count' => 1
                    ],
                ],
            ],
            [
                'alias' => 'notice',
                'name' => 'Notices',
                'data' => [
                    [
                        'alias' => 'notice_test',
                        'name' => 'Test notice',
                        'count' => 1
                    ],
                ],
            ],
        ], $summary);

        $data = $reportCollector->getData();
        $this->assertEquals([
            'error' => [
                'error_test' => [
                    [
                        'message' => 'error test 1',
                        'extra' => [
                            'error_test' => 1
                        ],
                    ],
                    [
                        'message' => 'error test 2',
                        'extra' => [
                            'error_test' => 2
                        ],
                    ],
                ],
                'error_unknown' => [
                    [
                        'message' => 'error unknown',
                        'extra' => [
                            'error_unknown' => 1
                        ],
                    ],
                ],
            ],
            'warning' => [
                'warning_test' => [
                    [
                        'message' => 'warning test 1',
                        'extra' => [
                            'warning_test' => 1
                        ],
                    ],
                ],
            ],
            'notice' => [
                'notice_test' => [
                    [
                        'message' => 'notice test 1',
                        'extra' => [
                            'notice_test' => 1
                        ],
                    ],
                ],
            ],
        ], $data);
    }
}
