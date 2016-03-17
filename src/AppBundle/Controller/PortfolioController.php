<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Portfolio;
use AppBundle\Form\PortfolioType;

/**
 * @Security("has_role('ROLE_USER')")
 */
class PortfolioController extends Controller
{
    /**
     * @Route("/portfolio", name="portfolio_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $portfolios = $em->getRepository('AppBundle:Portfolio')->findAll();

        return [
            'portfolios' => $portfolios,
        ];
    }

    /**
     * @Route("/portfolio/new", name="portfolio_new", defaults={"portfolio" = null})
     * @Route("/portfolio/{id}/edit", name="portfolio_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Portfolio $portfolio = null)
    {
        if (!$portfolio) {
            $portfolio = new Portfolio();
            $portfolio->setUser($this->getUser());
        }
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($portfolio);
            $em->flush();

            return $this->redirectToRoute('portfolio_show', ['id' => $portfolio->getId()]);
        }

        return [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/portfolio/{id}", name="portfolio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Portfolio $portfolio)
    {
        $yahooFinance = $this->get('app.service.finance_api');

        $result = [];
        foreach ($portfolio->getStocks() as $stock) {
            $result[$stock->code] = $yahooFinance->stockToArray($stock->code);
        }

        return [
            'portfolio' => $portfolio,
            'graphData' => $yahooFinance->sumResults($result),
        ];
    }

    /**
     * @Route("/portfolio/{id}/delete", name="portfolio_delete")
     * @Method("GET")
     */
    public function deleteAction(Portfolio $portfolio)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($portfolio);
        $em->flush();

        return $this->redirectToRoute('portfolio_index');
    }
}
