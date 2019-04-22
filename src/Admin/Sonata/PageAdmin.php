<?php

namespace App\Admin\Sonata;

use App\Entity\Sonata\Page;
use App\Entity\Sonata\Site;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\PageBundle\Admin\PageAdmin as SonataPageAdmin;

/**
 * Class PageAdmin.
 *
 * @author Phuc Vo <van-phuc.vo@ekino.com>
 */
class PageAdmin extends SonataPageAdmin
{
    protected $translationDomain = 'admin';

    /**
     * {@inheritdoc}
     */
    public function configureActionButtons($action, $object = null)
    {
        $actions    = parent::configureActionButtons($action, $object);
        $pageGlobal = $this->getGlobalPage();

        // If the current site has a global page, and we are not currently editing it
        // we add a shortcut button to the navbar for it
        if ($pageGlobal &&
            (is_null($this->getSubject())) ||
            (!is_null($this->getSubject()) && $pageGlobal->getId() !== $this->getSubject()->getId())
        ) {
            $actions['global']['template'] = 'Page/global_button.html.twig';
        }

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        parent::configureTabMenu($menu, $action, $childAdmin);

        // Add view page only for static page & already existing pages
        if (
            $this->getSubject() &&
            $this->getSubject()->getId() &&
            !$this->getSubject()->isHybrid() &&
            !$this->getSubject()->isInternal()
        ) {
            /** @var Site $site */
            $site     = $this->getSubject()->getSite();
            $viewPage = $menu->getChild('view_page');

            if ($viewPage) {
                $viewPage->setUri(sprintf(
                    '%s://%s%s%s',
                    $this->getRequest()->getScheme(),
                    $site->getHost(),
                    $site->getRelativePath(), $this->getSubject()->getUrl()
                ));
                $viewPage->setLinkAttribute('target', '_blank');
            }
        }

        $pageGlobal = $this->getGlobalPage();

        if (!is_null($pageGlobal) && !is_null($this->getSubject())) {
            if ($pageGlobal->getId() === $this->getSubject()->getId()) {
                $menu->removeChild('sidemenu.link_edit_page');
            }
        }

        $menu->removeChild('sidemenu.link_list_snapshots');
        $menu->removeChild('sidemenu.link_list_blocks');
    }

    /**
     * @return object|null
     */
    public function getGlobalPage()
    {
        $admin = $this->isChild() ? $this->getParent() : $this;
        // If site is specified in the request parameter
        if ($admin->getRequest()->query->has('site')) {
            $siteId = $admin->getRequest()->query->get('site');
        } elseif (!is_null($this->getSubject()) && !is_null($this->getSubject()->getSite())) {
            $siteId = $this->getSubject()->getSite()->getId();
        } else {
            return null;
        }

        return $admin->getModelManager()->findOneBy(Page::class, [
            'routeName' => Page::GLOBAL_PAGE_ROUTE_NAME,
            'site'      => $siteId,
        ]);
    }
}
