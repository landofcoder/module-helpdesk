<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Model;

use Magento\Store\Model\ScopeInterface;

class Sender
{
    /**
     * Sender email
     */
    const SENDER_EMAIL='trans_email/ident_general/email';
    /**
     * @var \Lof\HelpDesk\Helper\Data
     */
    protected $helper;
    /**
     * @var Template\TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var string|null
     */
    protected $messageSubject = null;

    /**
     * @var string|null
     */
    protected $messageBody = null;
    /**
     * @var string|null
     */
    protected $emailSubject = null;

    /**
     * @var string|null
     */
    protected $emailContent = null;

    public $_storeManager;

    protected $_priceCurrency;

    protected $_transportBuilder;

    protected $helpData;

    protected $config;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    protected $messageManager;
    protected $_url;

    public function __construct(
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Lof\HelpDesk\Model\TransportBuilder $transportBuilder,
        \Magento\Framework\Mail\Template\TransportBuilder $_transportBuilder,
        \Lof\HelpDesk\Model\Config $config,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Lof\HelpDesk\Helper\Data $helper,
        \Magento\Backend\Helper\Data $helpData,
        \Magento\Framework\Url $url
    ) {
        $this->messageManager = $messageManager;
        $this->config = $config;
        $this->helpData = $helpData;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $_transportBuilder;
        $this->transportBuilder = $transportBuilder;
        $this->helper = $helper;
        $this->_url = $url;
    }

    public function sendEmailTicket($data)
    {
        try {
            $postObject = new \Magento\Framework\DataObject();
            $data['urllogin'] = $this->_url->getUrl('lofhelpdesk/ticket/index');
            $data['description'] = $data['message'];
            $postObject->setData($data);
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->helper->getConfig('email_settings/new_message_template'))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                ->addTo($data['customer_email'], $data['customer_name'])
                ->getTransport();
            try {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->messageManager->addError(
                $e->getMessage()
                );
            return;
        }
    }

    public function sendEmail($data)
    {
        $arg = $emailData = [];
        $emailData['store_id'] = $data['store_id'];
        $emailData['saved_subject'] = $data['subject'];
        $emailData['saved_content'] = __("There is a new comment on the support ticket in the SMTP PRO category from Land of Coder. Here's what they said:") . '<div style="padding-left:20px;margin:0;border-left:2px solid #ccc;color:#888">' . $data['message'] . '</div><p style="padding:20px 0 0 0;margin:0"><b>' . __('Do not reply to this email!') . '</b></p>';
        $recipientEmail = $data['customer_email'];
        $emailData['recipient_name'] = $data['customer_name'];
        $this->transportBuilder
            ->setTemplateOptions([
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $emailData['store_id']
            ]);

        $this->transportBuilder->setTemplateVars($arg);

        $this->transportBuilder->setTemplateData(
            [
                'template_subject' => ('New message from ticket ' . $emailData['saved_subject']),
                'template_text' => ($emailData['saved_content'])
            ]
        );

        $this->transportBuilder->setFrom($this->helper->getConfig('email_settings/sender_email_identity'));

        $this->transportBuilder->addTo($recipientEmail, $emailData['recipient_name']);

        $this->prefixSubject = '';

        $transport = $this->transportBuilder->getTransport();
        return $transport;
    }

    public function statusTicket($data)
    {
        try {
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->helper->getConfig('email_settings/status_ticket_template'))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                ->addTo($data['customer_email'])
                ->setReplyTo($data['customer_email'])
                ->getTransport();
            try {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->messageManager->addError(
                $e->getMessage()
                );
            return;
        }
    }

    public function assignTicket($data)
    {
        try {
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->helper->getConfig('email_settings/assign_ticket_template'))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                ->addTo($data['customer_email'])
                ->setReplyTo($data['customer_email'])
                ->getTransport();
            try {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->messageManager->addError(
                $e->getMessage()
                );
            return;
        }
    }

    public function reminderTicket($data)
    {
        foreach ($data['email_to'] as $key => $email_to) {
            try {
                $postObject = new \Magento\Framework\DataObject();

                $postObject->setData($data);
                $transport = $this->_transportBuilder
                    ->setTemplateIdentifier($this->helper->getConfig('email_settings/reminder_template'))
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                    )
                    ->setTemplateVars(['data' => $postObject])
                    ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                    ->addTo($email_to)
                    ->setReplyTo($email_to)
                    ->getTransport();

                try {
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                    $this->messageManager->addError(
                        $e->getMessage()
                        );
                }
            } catch (\Exception $e) {
                $this->inlineTranslation->resume();
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
                return;
            }
        }
    }

    public function newTicket($data)
    {
        if ($data) {
            try {
                $postObject = new \Magento\Framework\DataObject();
                $data['title'] = __('Send Ticket');
                $sender =[];
                $sender ['email'] = $this->helper->getConfigs(
                    self::SENDER_EMAIL
                );
                $sender['name'] = 'admin';

                $url = $this->helpData->getHomePageUrl();
                $data['urllogin'] = $url;
                $postObject->setData($data);

                $transport = $this->_transportBuilder
                        ->setTemplateIdentifier($this->helper->getConfig('email_settings/new_ticket_template'))
                        ->setTemplateOptions(
                            [
                                'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
                                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                            ]
                        )
                        ->setTemplateVars(['data' => $postObject])
                        ->setFrom($sender)
                        ->addTo($sender['email'])
                        ->setReplyTo($sender['email'])
                        ->getTransport();

                try {
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                    $this->messageManager->addSuccess(
                        __('Thank you for send ticket')
                    );
                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                    $this->messageManager->addError(
                        $e->getMessage()
                        );
                }
            } catch (\Exception $e) {
                $this->inlineTranslation->resume();
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
                return;
            }
        }
    }

    public function newMessage($data)
    {
        if ($data) {
            try {
                $postObject = new \Magento\Framework\DataObject();

                $postObject->setData($data);
                $storeScope = ScopeInterface::SCOPE_STORE;

                $transport = $this->_transportBuilder
                    ->setTemplateIdentifier($this->helper->getConfig('email_settings/new_message_template'))
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                    )
                    ->setTemplateVars(['data' => $postObject])
                    ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                    ->addTo($data['email'])
                    ->setReplyTo($data['email'])
                    ->getTransport();
                try {
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                    $this->messageManager->addError(
                        $e->getMessage()
                        );
                }
            } catch (\Exception $e) {
                $this->inlineTranslation->resume();
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
                return;
            }
        }
    }

    public function sendEmailChat($data)
    {       
         try {
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);
            $admin_email = $this->helper->getConfig('email_settings/email_admin');
            $default_admin_email = "";
            if(isset($data["user_id"]) && $data["user_id"]){
                $user = $this->userFactory->create()->load((int)$data["user_id"]);
                $default_admin_email = $user->getEmail();
            }
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->helper->getConfig('email_settings/customer_chat_template'))

            ->setTemplateOptions(
                [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ])
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
            ->addTo($admin_email)
            ->setReplyTo($admin_email)
            ->getTransport();
 
            try  {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch(\Exception $e){
                $error = true;
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
            }
            //Send same email to default assigned admin user email.
            if($default_admin_email){
                $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->helper->getConfig('email_settings/customer_chat_template'))

                ->setTemplateOptions(
                    [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
                ->addTo($default_admin_email)
                ->setReplyTo($default_admin_email)
                ->getTransport();
    
                try  {
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch(\Exception $e){
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                        );
                    $this->messageManager->addError(
                        $e->getMessage()
                        );
                }
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
            $this->messageManager->addError(
                $e->getMessage()
                );
            return;
        }
    }

    public function sendAdminChat($data)
    {       
         try {
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($data);
            $customer_email = $data['customer_email'];
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->helper->getConfig('email_settings/admin_reply_template'))

            ->setTemplateOptions(
                [
                 'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ])
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($this->helper->getConfig('email_settings/sender_email_identity'))
            ->addTo($customer_email)
            ->setReplyTo($customer_email)
            ->getTransport();
            try  {
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch(\Exception $e){
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                $this->messageManager->addError(
                    $e->getMessage()
                    );
            }
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
                );
            $this->messageManager->addError(
                $e->getMessage()
                );
            return;
        }
    }

    /**
     * Get email body
     *
     * @return string
     */
    public function getEmailContent($queue)
    {
        if ($this->emailContent == null) {
            $this->getPreviewEmail($queue);
            return $this->transportBuilder->getMessageContent();
        }
        return $this->emailContent;
    }

    /**
     * Get email subject
     *
     * @return null|string
     */
    public function getEmailSubject($queue)
    {
        if ($this->emailSubject == null) {
            $this->getPreviewEmail($queue);
            return $this->transportBuilder->getMessageSubject();
        }
        return $this->emailSubject;
    }

    /**
     * Get email body
     *
     * @return string
     */
    public function getMessageContent($queue)
    {
        if ($this->messageBody == null) {
            $this->getPreview($queue);
            return $this->transportBuilder->getMessageContent();
        }
        return $this->messageBody;
    }

    /**
     * Get email subject
     *
     * @return null|string
     */
    public function getMessageSubject($queue)
    {
        if ($this->messageSubject == null) {
            $this->getPreview($queue);
            return $this->transportBuilder->getMessageSubject();
        }
        return $this->messageSubject;
    }
}
