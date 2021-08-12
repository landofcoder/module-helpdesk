<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Cleanlogs extends Command
{

    const NAME_ARGUMENT = "name";
    const NAME_OPTION = "option";

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * Cache
     *
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $_cache;

    protected $chatmessageFactory;

    protected $helper;

    protected $_date;

    /**
     * Constructor.
     *
     * @param \Magento\Framework\App\ResourceConnection $resource 
     * @param \Magento\Framework\App\CacheInterface $cache
     * @param \Lof\HelpDesk\Model\ChatMessageFactory $chatmessageFactory
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @api
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\CacheInterface $cache,
        \Lof\HelpDesk\Model\ChatMessageFactory $chatmessageFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
        ) {
        $this->_resource = $resource;
        $this->_cache = $cache;
        $this->helper = $helper;
        $this->_date = $date;
        $this->chatmessageFactory = $chatmessageFactory;
        parent::__construct();
        
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {

        try {
            $collection = $this->chatmessageFactory->create()->getCollection();
            $clean_older_day = $this->helper->getConfig("automation/clean_older_day");
            if($clean_older_day){
                $current_date = $this->helper->getTimezoneDateTime();
                $currentDateTime = strtotime($current_date);
                $clean_older_day = '- '.(int)$clean_older_day.' days';//2021-05-20 04:35:35
                $olderDate = date('Y-m-d H:i:s',strtotime($clean_older_day, $currentDateTime));
                $collection->addFieldToFilter('created_at', ['lteq' => $olderDate]);
            }
            $totals = $collection->count();
            foreach ($collection as $key => $model) {
                $model->delete();
            }
            $output->writeln("The Chat Messages has been flushed. Clean ".$totals." records");
        } catch (\Exception $e) {
            $output->writeln("Something went wrong in progressing.");
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("lof_helpdesk:cleanchat");
        $this->setDescription("Clean Chat Message Logs");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);
        parent::configure();
    }
}
